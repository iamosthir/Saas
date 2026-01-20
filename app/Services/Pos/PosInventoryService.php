<?php

namespace App\Services\Pos;

use App\Models\Pos\PosInventoryCost;
use App\Models\Pos\PosInventoryMovement;
use App\Models\Pos\PosSetting;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;

class PosInventoryService
{
    /**
     * Deduct stock after sale
     */
    public function deductStock(
        int $merchantId,
        int $productId,
        ?int $variationId,
        int $quantity,
        string $referenceType,
        int $referenceId
    ): void {
        DB::transaction(function () use ($merchantId, $productId, $variationId, $quantity, $referenceType, $referenceId) {
            // Get current stock
            $currentStock = $this->getCurrentStock($productId, $variationId);

            // Check if we allow negative stock
            $settings = PosSetting::getForMerchant($merchantId);
            if (!$settings->allow_negative_stock && $currentStock < $quantity) {
                throw new \Exception("Insufficient stock. Available: {$currentStock}, Requested: {$quantity}");
            }

            // Update stock
            if ($variationId) {
                ProductVariation::where('id', $variationId)->decrement('quantity', $quantity);
            }

            // Update product total_stock
            $this->updateProductTotalStock($productId);

            // Get unit cost for the movement record
            $unitCost = $this->getUnitCost($merchantId, $productId, $variationId, $quantity);

            // Consume from cost layers if using FIFO
            if ($settings->usesFifo()) {
                $this->consumeFifoCostLayers($merchantId, $productId, $variationId, $quantity);
            }

            // Log the movement
            $this->logMovement(
                $merchantId,
                $productId,
                $variationId,
                'sale',
                -$quantity,
                $currentStock,
                $currentStock - $quantity,
                $unitCost,
                $referenceType,
                $referenceId
            );
        });
    }

    /**
     * Restore stock (for void/refund)
     */
    public function restoreStock(
        int $merchantId,
        int $productId,
        ?int $variationId,
        int $quantity,
        float $unitCost,
        string $referenceType,
        int $referenceId
    ): void {
        DB::transaction(function () use ($merchantId, $productId, $variationId, $quantity, $unitCost, $referenceType, $referenceId) {
            // Get current stock
            $currentStock = $this->getCurrentStock($productId, $variationId);

            // Update stock
            if ($variationId) {
                ProductVariation::where('id', $variationId)->increment('quantity', $quantity);
            }

            // Update product total_stock
            $this->updateProductTotalStock($productId);

            // Add cost layer back (for FIFO)
            $settings = PosSetting::getForMerchant($merchantId);
            if ($settings->usesFifo()) {
                $this->addCostLayer($merchantId, $productId, $variationId, $quantity, $unitCost, $referenceType, $referenceId);
            }

            // Log the movement
            $this->logMovement(
                $merchantId,
                $productId,
                $variationId,
                'void',
                $quantity,
                $currentStock,
                $currentStock + $quantity,
                $unitCost,
                $referenceType,
                $referenceId
            );
        });
    }

    /**
     * Adjust stock manually
     */
    public function adjustStock(
        int $merchantId,
        int $productId,
        ?int $variationId,
        int $quantity,
        ?float $unitCost = null,
        ?string $notes = null
    ): PosInventoryMovement {
        return DB::transaction(function () use ($merchantId, $productId, $variationId, $quantity, $unitCost, $notes) {
            // Get current stock
            $currentStock = $this->getCurrentStock($productId, $variationId);
            $newStock = $currentStock + $quantity;

            // Check if we allow negative stock
            $settings = PosSetting::getForMerchant($merchantId);
            if (!$settings->allow_negative_stock && $newStock < 0) {
                throw new \Exception("Cannot adjust stock below zero. Current: {$currentStock}, Adjustment: {$quantity}");
            }

            // Update stock
            if ($variationId) {
                if ($quantity > 0) {
                    ProductVariation::where('id', $variationId)->increment('quantity', $quantity);
                } else {
                    ProductVariation::where('id', $variationId)->decrement('quantity', abs($quantity));
                }
            }

            // Update product total_stock
            $this->updateProductTotalStock($productId);

            // If adding stock with a cost, create cost layer
            if ($quantity > 0 && $unitCost !== null && $settings->usesFifo()) {
                $this->addCostLayer($merchantId, $productId, $variationId, $quantity, $unitCost);
            }

            // If removing stock, consume from cost layers
            if ($quantity < 0 && $settings->usesFifo()) {
                $this->consumeFifoCostLayers($merchantId, $productId, $variationId, abs($quantity));
            }

            // Log the movement
            return $this->logMovement(
                $merchantId,
                $productId,
                $variationId,
                'adjustment',
                $quantity,
                $currentStock,
                $newStock,
                $unitCost,
                null,
                null,
                $notes
            );
        });
    }

    /**
     * Get unit cost based on costing method
     */
    public function getUnitCost(
        int $merchantId,
        int $productId,
        ?int $variationId,
        int $quantity = 1,
        ?string $costingMethod = null
    ): float {
        $settings = PosSetting::getForMerchant($merchantId);
        $method = $costingMethod ?? $settings->costing_method;

        if ($method === 'fifo') {
            return $this->getFifoCost($merchantId, $productId, $variationId, $quantity);
        }

        return $this->getAverageCost($productId, $variationId);
    }

    /**
     * Get FIFO cost (cost from oldest inventory layers)
     */
    protected function getFifoCost(int $merchantId, int $productId, ?int $variationId, int $quantity): float
    {
        $query = PosInventoryCost::where('merchant_id', $merchantId)
            ->where('product_id', $productId)
            ->withStock()
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc');

        if ($variationId) {
            $query->where('product_variation_id', $variationId);
        } else {
            $query->whereNull('product_variation_id');
        }

        $layers = $query->get();

        if ($layers->isEmpty()) {
            // Fall back to average cost
            return $this->getAverageCost($productId, $variationId);
        }

        $totalCost = 0;
        $remainingQty = $quantity;

        foreach ($layers as $layer) {
            if ($remainingQty <= 0) break;

            $useQty = min($layer->quantity, $remainingQty);
            $totalCost += $useQty * $layer->unit_cost;
            $remainingQty -= $useQty;
        }

        // If we don't have enough cost layers, use last known cost for remainder
        if ($remainingQty > 0) {
            $lastCost = $layers->last()?->unit_cost ?? $this->getAverageCost($productId, $variationId);
            $totalCost += $remainingQty * $lastCost;
        }

        return $quantity > 0 ? $totalCost / $quantity : 0;
    }

    /**
     * Get average cost
     */
    protected function getAverageCost(int $productId, ?int $variationId): float
    {
        if ($variationId) {
            $variation = ProductVariation::find($variationId);
            return $variation?->average_price ?? $variation?->purchase_price ?? 0;
        }

        $product = Product::find($productId);
        return $product?->purchase_price ?? 0;
    }

    /**
     * Consume from FIFO cost layers
     */
    protected function consumeFifoCostLayers(int $merchantId, int $productId, ?int $variationId, int $quantity): void
    {
        $query = PosInventoryCost::where('merchant_id', $merchantId)
            ->where('product_id', $productId)
            ->withStock()
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc');

        if ($variationId) {
            $query->where('product_variation_id', $variationId);
        } else {
            $query->whereNull('product_variation_id');
        }

        $layers = $query->get();
        $remainingQty = $quantity;

        foreach ($layers as $layer) {
            if ($remainingQty <= 0) break;

            $useQty = min($layer->quantity, $remainingQty);
            $layer->quantity -= $useQty;
            $layer->save();

            $remainingQty -= $useQty;
        }
    }

    /**
     * Add a cost layer
     */
    public function addCostLayer(
        int $merchantId,
        int $productId,
        ?int $variationId,
        int $quantity,
        float $unitCost,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): PosInventoryCost {
        return PosInventoryCost::create([
            'merchant_id' => $merchantId,
            'product_id' => $productId,
            'product_variation_id' => $variationId,
            'unit_cost' => $unitCost,
            'quantity' => $quantity,
            'original_quantity' => $quantity,
            'received_date' => now()->toDateString(),
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Get current stock level
     */
    public function getCurrentStock(int $productId, ?int $variationId): int
    {
        if ($variationId) {
            $variation = ProductVariation::find($variationId);
            return $variation?->quantity ?? 0;
        }

        $product = Product::find($productId);
        return $product?->total_stock ?? 0;
    }

    /**
     * Check if stock is sufficient
     */
    public function hasStock(int $productId, ?int $variationId, int $requiredQty): bool
    {
        return $this->getCurrentStock($productId, $variationId) >= $requiredQty;
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts(int $merchantId)
    {
        return Product::where('merchant_id', $merchantId)
            ->whereColumn('total_stock', '<=', 'low_stock_threshold')
            ->with('variations')
            ->get();
    }

    /**
     * Update product total_stock from variations
     */
    protected function updateProductTotalStock(int $productId): void
    {
        $product = Product::find($productId);
        if ($product) {
            $totalStock = $product->variations()->sum('quantity');
            $product->total_stock = $totalStock;
            $product->save();
        }
    }

    /**
     * Log inventory movement
     */
    protected function logMovement(
        int $merchantId,
        int $productId,
        ?int $variationId,
        string $movementType,
        int $quantity,
        int $quantityBefore,
        int $quantityAfter,
        ?float $unitCost,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null
    ): PosInventoryMovement {
        return PosInventoryMovement::create([
            'merchant_id' => $merchantId,
            'product_id' => $productId,
            'product_variation_id' => $variationId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'unit_cost' => $unitCost,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
        ]);
    }

    /**
     * Get inventory movements for a product
     */
    public function getMovements(int $merchantId, ?int $productId = null, int $limit = 50)
    {
        $query = PosInventoryMovement::where('merchant_id', $merchantId)
            ->with(['product', 'productVariation', 'createdBy'])
            ->orderBy('created_at', 'desc');

        if ($productId) {
            $query->where('product_id', $productId);
        }

        return $query->limit($limit)->get();
    }
}
