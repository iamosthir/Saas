<?php

namespace App\Services\Manufacturing;

use App\Models\Manufacturing\ProductionBatch;
use App\Models\Manufacturing\ProductionBatchIngredient;
use App\Models\Manufacturing\ProductRecipe;
use App\Models\ProductVariation;
use App\Models\Pos\PosInventoryCost;
use Illuminate\Support\Facades\DB;

class ProductionService
{
    protected RawMaterialInventoryService $rawMaterialService;

    public function __construct(RawMaterialInventoryService $rawMaterialService)
    {
        $this->rawMaterialService = $rawMaterialService;
    }

    /**
     * Create a new production batch (draft)
     */
    public function createBatch(
        int $recipeId,
        float $multiplier = 1,
        ?string $notes = null,
        ?string $productionDate = null,
        ?string $expiryDate = null
    ): ProductionBatch {
        $recipe = ProductRecipe::with('ingredients.rawMaterial', 'ingredients.unit')
            ->findOrFail($recipeId);

        $batch = ProductionBatch::create([
            'merchant_id' => auth()->user()->merchant_id,
            'recipe_id' => $recipeId,
            'product_id' => $recipe->product_id,
            'product_variation_id' => $recipe->product_variation_id,
            'planned_quantity' => $recipe->output_quantity * $multiplier,
            'labor_cost' => $recipe->labor_cost * $multiplier,
            'overhead_cost' => $recipe->overhead_cost * $multiplier,
            'status' => ProductionBatch::STATUS_DRAFT,
            'production_date' => $productionDate ?? now()->toDateString(),
            'expiry_date' => $expiryDate,
            'notes' => $notes,
        ]);

        // Pre-populate batch ingredients from recipe
        foreach ($recipe->ingredients as $ingredient) {
            ProductionBatchIngredient::create([
                'batch_id' => $batch->id,
                'raw_material_id' => $ingredient->raw_material_id,
                'unit_id' => $ingredient->unit_id,
                'required_quantity' => $ingredient->getEffectiveQuantity() * $multiplier,
                'unit_cost' => $ingredient->rawMaterial->average_price,
            ]);
        }

        return $batch->load('ingredients.rawMaterial', 'ingredients.unit');
    }

    /**
     * Start production (move to in_progress)
     */
    public function startProduction(int $batchId): ProductionBatch
    {
        $batch = ProductionBatch::with('ingredients.rawMaterial', 'ingredients.unit')
            ->findOrFail($batchId);

        if (!$batch->isDraft()) {
            throw new \Exception('Only draft batches can be started');
        }

        // Verify all ingredients have sufficient stock
        foreach ($batch->ingredients as $ingredient) {
            $requiredQty = $ingredient->getRequiredQuantityInBaseUnit();
            if ($ingredient->rawMaterial->current_stock < $requiredQty) {
                throw new \Exception(
                    "Insufficient stock for {$ingredient->rawMaterial->name}. " .
                    "Required: {$requiredQty}, Available: {$ingredient->rawMaterial->current_stock}"
                );
            }
        }

        $batch->status = ProductionBatch::STATUS_IN_PROGRESS;
        $batch->save();

        return $batch;
    }

    /**
     * Complete production - deduct raw materials, add finished products
     */
    public function completeProduction(
        int $batchId,
        float $actualQuantity,
        ?array $actualIngredients = null
    ): ProductionBatch {
        return DB::transaction(function () use ($batchId, $actualQuantity, $actualIngredients) {
            $batch = ProductionBatch::with('ingredients.rawMaterial', 'ingredients.unit', 'product')
                ->findOrFail($batchId);

            if (!$batch->canBeCompleted()) {
                throw new \Exception('Batch cannot be completed');
            }

            $merchantId = $batch->merchant_id;
            $totalMaterialCost = 0;

            // Process each ingredient
            foreach ($batch->ingredients as $ingredient) {
                // Use actual quantity if provided, otherwise use required
                $actualQty = $actualIngredients[$ingredient->raw_material_id] ?? null;
                $quantityToUse = $actualQty ?? $ingredient->required_quantity;

                $ingredient->actual_quantity = $quantityToUse;

                // Convert to base unit for deduction
                $baseQty = $ingredient->unit->toBaseUnit($quantityToUse);

                // Deduct from raw material stock
                $movement = $this->rawMaterialService->deductStock(
                    $merchantId,
                    $ingredient->raw_material_id,
                    $baseQty,
                    'production',
                    'production_batches',
                    $batch->id
                );

                // Update ingredient cost
                $ingredient->unit_cost = abs($movement->unit_cost);
                $ingredient->total_cost = $baseQty * abs($movement->unit_cost);
                $ingredient->save();

                $totalMaterialCost += $ingredient->total_cost;
            }

            // Update batch
            $batch->actual_quantity = $actualQuantity;
            $batch->material_cost = $totalMaterialCost;
            $batch->status = ProductionBatch::STATUS_COMPLETED;
            $batch->completed_by = auth()->id();
            $batch->completed_at = now();
            $batch->calculateCosts();
            $batch->save();

            // Add finished products to inventory
            $this->addFinishedProducts($batch);

            return $batch->fresh(['ingredients.rawMaterial', 'product', 'productVariation']);
        });
    }

    /**
     * Cancel a production batch
     */
    public function cancelBatch(int $batchId, ?string $reason = null): ProductionBatch
    {
        $batch = ProductionBatch::findOrFail($batchId);

        if (!$batch->canBeCancelled()) {
            throw new \Exception('Batch cannot be cancelled');
        }

        $batch->status = ProductionBatch::STATUS_CANCELLED;
        $batch->notes = $batch->notes
            ? $batch->notes . "\n\nCancellation reason: " . ($reason ?? 'Not specified')
            : "Cancellation reason: " . ($reason ?? 'Not specified');
        $batch->save();

        return $batch;
    }

    /**
     * Clone a completed production batch
     */
    public function cloneBatch(int $batchId): ProductionBatch
    {
        return DB::transaction(function () use ($batchId) {
            $originalBatch = ProductionBatch::with('ingredients.rawMaterial', 'ingredients.unit')
                ->findOrFail($batchId);

            if ($originalBatch->status !== ProductionBatch::STATUS_COMPLETED) {
                throw new \Exception('Only completed batches can be cloned');
            }

            // Create new batch with same settings
            $newBatch = ProductionBatch::create([
                'merchant_id' => $originalBatch->merchant_id,
                'recipe_id' => $originalBatch->recipe_id,
                'product_id' => $originalBatch->product_id,
                'product_variation_id' => $originalBatch->product_variation_id,
                'planned_quantity' => $originalBatch->actual_quantity ?? $originalBatch->planned_quantity,
                'actual_quantity' => $originalBatch->actual_quantity,
                'labor_cost' => $originalBatch->labor_cost,
                'overhead_cost' => $originalBatch->overhead_cost,
                'material_cost' => $originalBatch->material_cost,
                'status' => ProductionBatch::STATUS_COMPLETED,
                'production_date' => now()->toDateString(),
                'expiry_date' => $originalBatch->expiry_date,
                'notes' => 'Cloned from batch: ' . $originalBatch->batch_number,
                'completed_by' => auth()->id(),
                'completed_at' => now(),
            ]);

            // Clone ingredients
            foreach ($originalBatch->ingredients as $ingredient) {
                $newIngredient = ProductionBatchIngredient::create([
                    'batch_id' => $newBatch->id,
                    'raw_material_id' => $ingredient->raw_material_id,
                    'unit_id' => $ingredient->unit_id,
                    'required_quantity' => $ingredient->required_quantity,
                    'actual_quantity' => $ingredient->actual_quantity,
                    'unit_cost' => $ingredient->unit_cost,
                    'total_cost' => $ingredient->total_cost,
                ]);

                // Deduct stock for cloned ingredients
                $baseQty = $ingredient->unit->toBaseUnit($ingredient->actual_quantity ?? $ingredient->required_quantity);
                $this->rawMaterialService->deductStock(
                    $newBatch->merchant_id,
                    $ingredient->raw_material_id,
                    $baseQty,
                    'production',
                    'production_batches',
                    $newBatch->id
                );
            }

            // Recalculate costs
            $newBatch->calculateCosts();
            $newBatch->save();

            // Add finished products to inventory
            $this->addFinishedProducts($newBatch);

            return $newBatch->fresh(['ingredients.rawMaterial', 'product', 'productVariation']);
        });
    }

    /**
     * Add finished products to product inventory
     */
    protected function addFinishedProducts(ProductionBatch $batch): void
    {
        $quantity = $batch->actual_quantity;
        $unitCost = $batch->unit_cost;

        // Update product variation stock
        if ($batch->product_variation_id) {
            $variation = ProductVariation::find($batch->product_variation_id);
            if ($variation) {
                $oldQty = $variation->quantity;
                $oldAvgPrice = $variation->average_price ?? 0;

                // Update quantity
                $variation->quantity = $oldQty + $quantity;

                // Update weighted average price
                $totalValue = ($oldQty * $oldAvgPrice) + ($quantity * $unitCost);
                $variation->average_price = $variation->quantity > 0
                    ? $totalValue / $variation->quantity
                    : $unitCost;

                $variation->save();
            }
        }

        // Update product total_stock
        $batch->product->total_stock = $batch->product->variations()->sum('quantity');
        $batch->product->save();

        // Add cost layer for FIFO (using existing POS inventory system)
        $this->addProductCostLayer($batch, $quantity, $unitCost);
    }

    /**
     * Add cost layer to product inventory
     */
    protected function addProductCostLayer(ProductionBatch $batch, float $quantity, float $unitCost): void
    {
        // Check if PosInventoryCost model exists
        if (class_exists(PosInventoryCost::class)) {
            PosInventoryCost::create([
                'merchant_id' => $batch->merchant_id,
                'product_id' => $batch->product_id,
                'product_variation_id' => $batch->product_variation_id,
                'unit_cost' => $unitCost,
                'quantity' => $quantity,
                'original_quantity' => $quantity,
                'received_date' => $batch->production_date,
                'reference_type' => 'production_batches',
                'reference_id' => $batch->id,
            ]);
        }
    }

    /**
     * Check availability for a recipe
     */
    public function checkAvailability(int $recipeId, float $multiplier = 1): array
    {
        $recipe = ProductRecipe::with('ingredients.rawMaterial', 'ingredients.unit')
            ->findOrFail($recipeId);

        $availability = $recipe->getIngredientAvailability($multiplier);
        $canProduce = collect($availability)->every(fn($item) => $item['sufficient']);

        return [
            'can_produce' => $canProduce,
            'ingredients' => $availability,
            'estimated_output' => $recipe->output_quantity * $multiplier,
            'estimated_material_cost' => $recipe->calculateMaterialCost() * $multiplier,
            'estimated_total_cost' => $recipe->calculateTotalCost() * $multiplier,
            'estimated_unit_cost' => $recipe->calculateUnitCost(),
        ];
    }

    /**
     * Get production history
     */
    public function getProductionHistory(int $merchantId, array $filters = [])
    {
        $query = ProductionBatch::where('merchant_id', $merchantId)
            ->with(['recipe', 'product', 'productVariation', 'createdBy', 'completedBy']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('production_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('production_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get production summary for a period
     */
    public function getProductionSummary(int $merchantId, string $dateFrom, string $dateTo): array
    {
        $batches = ProductionBatch::where('merchant_id', $merchantId)
            ->where('status', ProductionBatch::STATUS_COMPLETED)
            ->whereBetween('production_date', [$dateFrom, $dateTo])
            ->get();

        return [
            'total_batches' => $batches->count(),
            'total_output' => $batches->sum('actual_quantity'),
            'total_material_cost' => $batches->sum('material_cost'),
            'total_labor_cost' => $batches->sum('labor_cost'),
            'total_overhead_cost' => $batches->sum('overhead_cost'),
            'total_cost' => $batches->sum('total_cost'),
            'average_unit_cost' => $batches->count() > 0
                ? $batches->sum('total_cost') / $batches->sum('actual_quantity')
                : 0,
        ];
    }
}
