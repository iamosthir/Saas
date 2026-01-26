<?php

namespace App\Services\Manufacturing;

use App\Models\Manufacturing\RawMaterial;
use App\Models\Manufacturing\RawMaterialMovement;
use App\Models\Manufacturing\RawMaterialCost;
use Illuminate\Support\Facades\DB;

class RawMaterialInventoryService
{
    /**
     * Add stock to a raw material (purchase)
     */
    public function addStock(
        int $merchantId,
        int $rawMaterialId,
        float $quantity,
        float $unitCost,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null
    ): RawMaterialMovement {
        return DB::transaction(function () use ($merchantId, $rawMaterialId, $quantity, $unitCost, $referenceType, $referenceId, $notes) {
            $material = RawMaterial::findOrFail($rawMaterialId);
            $currentStock = (float) $material->current_stock;
            $newStock = $currentStock + $quantity;

            // Update average price using weighted average
            $totalValue = ($currentStock * $material->average_price) + ($quantity * $unitCost);
            $newAveragePrice = $newStock > 0 ? $totalValue / $newStock : $unitCost;

            // Update material
            $material->current_stock = $newStock;
            $material->average_price = $newAveragePrice;
            $material->purchase_price = $unitCost;
            $material->save();

            // Create cost layer for FIFO
            $this->addCostLayer($merchantId, $rawMaterialId, $quantity, $unitCost, $referenceType, $referenceId);

            // Log movement
            return $this->logMovement(
                $merchantId,
                $rawMaterialId,
                RawMaterialMovement::TYPE_PURCHASE,
                $quantity,
                $currentStock,
                $newStock,
                $unitCost,
                $referenceType,
                $referenceId,
                $notes
            );
        });
    }

    /**
     * Deduct stock from a raw material
     */
    public function deductStock(
        int $merchantId,
        int $rawMaterialId,
        float $quantity,
        string $movementType,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null
    ): RawMaterialMovement {
        return DB::transaction(function () use ($merchantId, $rawMaterialId, $quantity, $movementType, $referenceType, $referenceId, $notes) {
            $material = RawMaterial::findOrFail($rawMaterialId);
            $currentStock = (float) $material->current_stock;

            if ($currentStock < $quantity) {
                throw new \Exception("Insufficient stock for {$material->name}. Available: {$currentStock}, Required: {$quantity}");
            }

            $newStock = $currentStock - $quantity;
            $material->current_stock = $newStock;
            $material->save();

            // Get unit cost using FIFO and consume layers
            $unitCost = $this->consumeFifoCostLayers($merchantId, $rawMaterialId, $quantity);

            return $this->logMovement(
                $merchantId,
                $rawMaterialId,
                $movementType,
                -$quantity, // Negative for deductions
                $currentStock,
                $newStock,
                $unitCost,
                $referenceType,
                $referenceId,
                $notes
            );
        });
    }

    /**
     * Adjust stock (manual adjustment)
     */
    public function adjustStock(
        int $merchantId,
        int $rawMaterialId,
        float $newStockLevel,
        ?float $unitCost = null,
        ?string $notes = null
    ): RawMaterialMovement {
        return DB::transaction(function () use ($merchantId, $rawMaterialId, $newStockLevel, $unitCost, $notes) {
            $material = RawMaterial::findOrFail($rawMaterialId);
            $currentStock = (float) $material->current_stock;
            $difference = $newStockLevel - $currentStock;

            if ($difference == 0) {
                throw new \Exception("Stock level is already at {$newStockLevel}");
            }

            $material->current_stock = $newStockLevel;
            $material->save();

            // Use provided unit cost or current average
            $cost = $unitCost ?? $material->average_price;

            // If adding stock, create a cost layer
            if ($difference > 0) {
                $this->addCostLayer($merchantId, $rawMaterialId, $difference, $cost, null, null);
            } else {
                // If removing stock, consume from FIFO layers
                $this->consumeFifoCostLayers($merchantId, $rawMaterialId, abs($difference));
            }

            return $this->logMovement(
                $merchantId,
                $rawMaterialId,
                RawMaterialMovement::TYPE_ADJUSTMENT,
                $difference,
                $currentStock,
                $newStockLevel,
                $cost,
                null,
                null,
                $notes ?? "Manual adjustment from {$currentStock} to {$newStockLevel}"
            );
        });
    }

    /**
     * Record waste/spoilage
     */
    public function recordWaste(
        int $merchantId,
        int $rawMaterialId,
        float $quantity,
        ?string $notes = null
    ): RawMaterialMovement {
        return $this->deductStock(
            $merchantId,
            $rawMaterialId,
            $quantity,
            RawMaterialMovement::TYPE_WASTE,
            null,
            null,
            $notes ?? 'Waste/Spoilage'
        );
    }

    /**
     * Get FIFO cost for a quantity (without consuming)
     */
    public function getFifoCost(int $merchantId, int $rawMaterialId, float $quantity): float
    {
        $layers = RawMaterialCost::where('merchant_id', $merchantId)
            ->where('raw_material_id', $rawMaterialId)
            ->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalCost = 0;
        $remaining = $quantity;

        foreach ($layers as $layer) {
            if ($remaining <= 0) break;

            $useQty = min($layer->quantity, $remaining);
            $totalCost += $useQty * $layer->unit_cost;
            $remaining -= $useQty;
        }

        // If not enough layers, use average price for remainder
        if ($remaining > 0) {
            $material = RawMaterial::find($rawMaterialId);
            $totalCost += $remaining * ($material->average_price ?? 0);
        }

        return $quantity > 0 ? $totalCost / $quantity : 0;
    }

    /**
     * Consume FIFO cost layers and return weighted average cost
     */
    protected function consumeFifoCostLayers(int $merchantId, int $rawMaterialId, float $quantity): float
    {
        $layers = RawMaterialCost::where('merchant_id', $merchantId)
            ->where('raw_material_id', $rawMaterialId)
            ->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalCost = 0;
        $totalConsumed = 0;
        $remaining = $quantity;

        foreach ($layers as $layer) {
            if ($remaining <= 0) break;

            $consumeQty = min($layer->quantity, $remaining);
            $totalCost += $consumeQty * $layer->unit_cost;
            $totalConsumed += $consumeQty;

            $layer->quantity -= $consumeQty;
            $layer->save();

            $remaining -= $consumeQty;
        }

        return $totalConsumed > 0 ? $totalCost / $totalConsumed : 0;
    }

    /**
     * Add a new cost layer
     */
    protected function addCostLayer(
        int $merchantId,
        int $rawMaterialId,
        float $quantity,
        float $unitCost,
        ?string $referenceType,
        ?int $referenceId
    ): RawMaterialCost {
        return RawMaterialCost::create([
            'merchant_id' => $merchantId,
            'raw_material_id' => $rawMaterialId,
            'unit_cost' => $unitCost,
            'quantity' => $quantity,
            'original_quantity' => $quantity,
            'received_date' => now()->toDateString(),
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Log an inventory movement
     */
    protected function logMovement(
        int $merchantId,
        int $rawMaterialId,
        string $movementType,
        float $quantity,
        float $quantityBefore,
        float $quantityAfter,
        ?float $unitCost,
        ?string $referenceType,
        ?int $referenceId,
        ?string $notes
    ): RawMaterialMovement {
        return RawMaterialMovement::create([
            'merchant_id' => $merchantId,
            'raw_material_id' => $rawMaterialId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'unit_cost' => $unitCost,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Get current stock for a raw material
     */
    public function getCurrentStock(int $rawMaterialId): float
    {
        return (float) RawMaterial::find($rawMaterialId)?->current_stock ?? 0;
    }

    /**
     * Check if material has sufficient stock
     */
    public function hasStock(int $rawMaterialId, float $quantity): bool
    {
        return $this->getCurrentStock($rawMaterialId) >= $quantity;
    }

    /**
     * Get low stock materials for a merchant
     */
    public function getLowStockMaterials(int $merchantId)
    {
        return RawMaterial::where('merchant_id', $merchantId)
            ->active()
            ->lowStock()
            ->with('unit', 'supplier', 'category')
            ->get();
    }

    /**
     * Get movement history for a material
     */
    public function getMovementHistory(int $rawMaterialId, int $limit = 50)
    {
        return RawMaterialMovement::where('raw_material_id', $rawMaterialId)
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get stock value for all materials of a merchant
     */
    public function getTotalStockValue(int $merchantId): float
    {
        return RawMaterial::where('merchant_id', $merchantId)
            ->active()
            ->get()
            ->sum(fn($m) => $m->current_stock * $m->average_price);
    }
}
