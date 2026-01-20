<?php

namespace App\Services\Pos;

use App\Models\Pos\PosSale;
use App\Models\Pos\PosSaleItem;
use App\Models\Pos\PosSetting;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;

class PosService
{
    protected PosInventoryService $inventoryService;
    protected PosPricingService $pricingService;
    protected PosPaymentService $paymentService;

    public function __construct(
        PosInventoryService $inventoryService,
        PosPricingService $pricingService,
        PosPaymentService $paymentService
    ) {
        $this->inventoryService = $inventoryService;
        $this->pricingService = $pricingService;
        $this->paymentService = $paymentService;
    }

    /**
     * Create a new draft sale
     */
    public function createSale(int $merchantId, ?int $customerId = null): PosSale
    {
        return PosSale::create([
            'merchant_id' => $merchantId,
            'customer_id' => $customerId,
            'sale_number' => PosSale::generateSaleNumber($merchantId),
            'status' => 'draft',
        ]);
    }

    /**
     * Add item to sale
     */
    public function addItem(PosSale $sale, array $itemData): PosSaleItem
    {
        $product = Product::findOrFail($itemData['product_id']);
        $variation = isset($itemData['product_variation_id'])
            ? ProductVariation::find($itemData['product_variation_id'])
            : null;

        $settings = PosSetting::getForMerchant($sale->merchant_id);

        // Get the price and cost
        $unitPrice = $variation ? $variation->price : $product->sell_price;
        $unitCost = $this->inventoryService->getUnitCost(
            $sale->merchant_id,
            $product->id,
            $variation?->id,
            $itemData['quantity'] ?? 1,
            $settings->costing_method
        );

        // Check if item already exists in sale
        $existingItem = $sale->items()
            ->where('product_id', $product->id)
            ->where('product_variation_id', $variation?->id)
            ->first();

        if ($existingItem) {
            // Update quantity
            $existingItem->quantity += ($itemData['quantity'] ?? 1);
            $existingItem->line_total = $existingItem->calculateLineTotal();
            $existingItem->save();
            $this->recalculateSale($sale);
            return $existingItem;
        }

        // Create new item
        $item = new PosSaleItem([
            'pos_sale_id' => $sale->id,
            'product_id' => $product->id,
            'product_variation_id' => $variation?->id,
            'product_name' => $product->name,
            'variation_name' => $variation?->var_name,
            'sku' => $variation?->sku ?? $product->sku,
            'barcode' => $variation?->barcode ?? $product->barcode,
            'quantity' => $itemData['quantity'] ?? 1,
            'unit_price' => $unitPrice,
            'unit_cost' => $unitCost,
            'discount_type' => $itemData['discount_type'] ?? null,
            'discount_amount' => $itemData['discount_amount'] ?? 0,
        ]);

        $item->line_total = $item->calculateLineTotal();
        $item->save();

        $this->recalculateSale($sale);

        return $item;
    }

    /**
     * Update item quantity
     */
    public function updateItemQuantity(PosSaleItem $item, int $quantity): PosSaleItem
    {
        if ($quantity <= 0) {
            return $this->removeItem($item);
        }

        $item->quantity = $quantity;
        $item->line_total = $item->calculateLineTotal();
        $item->save();

        $this->recalculateSale($item->sale);

        return $item;
    }

    /**
     * Apply discount to item
     */
    public function applyItemDiscount(PosSaleItem $item, ?string $discountType, float $discountAmount): PosSaleItem
    {
        $item->discount_type = $discountType;
        $item->discount_amount = $discountAmount;
        $item->line_total = $item->calculateLineTotal();
        $item->save();

        $this->recalculateSale($item->sale);

        return $item;
    }

    /**
     * Remove item from sale
     */
    public function removeItem(PosSaleItem $item): PosSaleItem
    {
        $sale = $item->sale;
        $item->delete();

        $this->recalculateSale($sale);

        return $item;
    }

    /**
     * Apply discount to entire sale
     */
    public function applySaleDiscount(PosSale $sale, ?string $discountType, float $discountAmount): PosSale
    {
        $sale->discount_type = $discountType;
        $sale->discount_amount = $discountAmount;

        $this->recalculateSale($sale);

        return $sale;
    }

    /**
     * Set customer for sale
     */
    public function setCustomer(PosSale $sale, ?int $customerId): PosSale
    {
        $sale->customer_id = $customerId;
        $sale->save();

        return $sale;
    }

    /**
     * Park a sale for later
     */
    public function parkSale(PosSale $sale, ?string $parkName = null): PosSale
    {
        $sale->status = 'parked';
        $sale->park_name = $parkName;
        $sale->save();

        return $sale;
    }

    /**
     * Unpark a sale (resume)
     */
    public function unparkSale(PosSale $sale): PosSale
    {
        $sale->status = 'draft';
        $sale->park_name = null;
        $sale->save();

        return $sale;
    }

    /**
     * Complete a sale with payment(s)
     */
    public function completeSale(PosSale $sale, array $payments): PosSale
    {
        return DB::transaction(function () use ($sale, $payments) {
            // Process payments
            $totalPaid = 0;
            $change = 0;

            foreach ($payments as $paymentData) {
                $payment = $this->paymentService->processPayment($sale, $paymentData);
                $totalPaid += $payment->amount;
                $change += $payment->change_given;
            }

            // Verify payment covers total
            if ($totalPaid < $sale->total_amount) {
                throw new \Exception('Insufficient payment amount');
            }

            // Deduct inventory
            foreach ($sale->items as $item) {
                $this->inventoryService->deductStock(
                    $sale->merchant_id,
                    $item->product_id,
                    $item->product_variation_id,
                    $item->quantity,
                    'pos_sales',
                    $sale->id
                );
            }

            // Update sale status
            $sale->status = 'completed';
            $sale->paid_amount = $totalPaid;
            $sale->change_amount = $change;
            $sale->completed_by = auth()->id();
            $sale->completed_at = now();
            $sale->save();

            return $sale->fresh(['items', 'payments', 'customer']);
        });
    }

    /**
     * Void a completed sale
     */
    public function voidSale(PosSale $sale): PosSale
    {
        return DB::transaction(function () use ($sale) {
            // Restore inventory
            foreach ($sale->items as $item) {
                $this->inventoryService->restoreStock(
                    $sale->merchant_id,
                    $item->product_id,
                    $item->product_variation_id,
                    $item->quantity,
                    $item->unit_cost,
                    'pos_sales',
                    $sale->id
                );
            }

            // Update sale status
            $sale->status = 'voided';
            $sale->save();

            return $sale;
        });
    }

    /**
     * Recalculate sale totals
     */
    public function recalculateSale(PosSale $sale): PosSale
    {
        $sale->refresh();
        $settings = PosSetting::getForMerchant($sale->merchant_id);

        // Calculate subtotal from items
        $subtotal = $sale->items->sum('line_total');

        // Calculate sale-level discount
        $discountValue = $this->pricingService->calculateDiscount(
            $subtotal,
            $sale->discount_type,
            $sale->discount_amount
        );

        // Calculate tax
        $taxableAmount = $subtotal - $discountValue;
        $taxAmount = $this->pricingService->calculateTax($taxableAmount, $settings->tax_rate);

        // Calculate total
        $total = $taxableAmount + $taxAmount;

        $sale->subtotal = $subtotal;
        $sale->discount_value = $discountValue;
        $sale->tax_rate = $settings->tax_rate;
        $sale->tax_amount = $taxAmount;
        $sale->total_amount = $total;
        $sale->save();

        return $sale;
    }

    /**
     * Get sale with all relations
     */
    public function getSaleWithDetails(int $saleId): PosSale
    {
        return PosSale::with(['items.product', 'items.productVariation', 'payments', 'customer', 'createdBy'])
            ->findOrFail($saleId);
    }

    /**
     * Get parked sales for merchant
     */
    public function getParkedSales(int $merchantId)
    {
        return PosSale::where('merchant_id', $merchantId)
            ->parked()
            ->with(['items', 'customer'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Get draft sales for merchant (active carts)
     */
    public function getDraftSales(int $merchantId)
    {
        return PosSale::where('merchant_id', $merchantId)
            ->draft()
            ->with(['items', 'customer'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Search products by name, SKU, or barcode
     */
    public function searchProducts(int $merchantId, string $query, int $limit = 20)
    {
        return Product::where('merchant_id', $merchantId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%")
                    ->orWhere('barcode', $query);
            })
            ->with(['variations' => function ($q) use ($query) {
                $q->where('sku', 'like', "%{$query}%")
                    ->orWhere('barcode', $query)
                    ->orWhereRaw('1=1'); // Include all variations for matching products
            }])
            ->limit($limit)
            ->get();
    }

    /**
     * Find product by barcode
     */
    public function findByBarcode(int $merchantId, string $barcode)
    {
        // First check variations
        $variation = ProductVariation::where('merchant_id', $merchantId)
            ->where('barcode', $barcode)
            ->with('product')
            ->first();

        if ($variation) {
            return [
                'product' => $variation->product,
                'variation' => $variation,
            ];
        }

        // Then check products
        $product = Product::where('merchant_id', $merchantId)
            ->where('barcode', $barcode)
            ->with('variations')
            ->first();

        if ($product) {
            return [
                'product' => $product,
                'variation' => null,
            ];
        }

        return null;
    }
}
