<?php

namespace App\Services\Pos;

use App\Models\Pos\PosSale;
use App\Models\Pos\PosSaleItem;
use App\Models\Pos\PosPayment;
use App\Models\Pos\PosInventoryMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class PosRefundService
{
    protected PosInventoryService $inventoryService;

    public function __construct(PosInventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Process a full refund
     */
    public function processFullRefund(PosSale $sale, array $data): PosSale
    {
        if ($sale->status !== 'completed') {
            throw new Exception('Only completed sales can be refunded');
        }

        if ($sale->sale_type === 'refund') {
            throw new Exception('Cannot refund a refund transaction');
        }

        DB::beginTransaction();
        try {
            // Create refund sale
            $refundSale = $this->createRefundSale($sale, $sale->items->toArray(), $data);

            // Mark original sale as refunded
            $sale->update(['status' => 'refunded']);

            // Restore inventory
            foreach ($sale->items as $item) {
                $this->restoreInventory($item, $item->quantity, $refundSale);
            }

            // Process refund payments (reverse original payments)
            $this->processRefundPayments($sale, $refundSale);

            DB::commit();
            return $refundSale->fresh(['items', 'payments']);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process a partial refund (specific items)
     */
    public function processPartialRefund(PosSale $sale, array $items, array $data): PosSale
    {
        if ($sale->status !== 'completed') {
            throw new Exception('Only completed sales can be refunded');
        }

        if ($sale->sale_type === 'refund') {
            throw new Exception('Cannot refund a refund transaction');
        }

        // Validate refund items
        $this->validateRefundItems($sale, $items);

        DB::beginTransaction();
        try {
            // Create refund sale
            $refundSale = $this->createRefundSale($sale, $items, $data);

            // Restore inventory for refunded items
            foreach ($items as $itemData) {
                $originalItem = $sale->items->find($itemData['id']);
                if ($originalItem) {
                    $this->restoreInventory($originalItem, $itemData['quantity'], $refundSale);
                }
            }

            // Calculate proportional refund amount
            $refundAmount = $refundSale->total_amount;

            // Process refund payment
            $this->processProportionalRefund($sale, $refundSale, $refundAmount);

            DB::commit();
            return $refundSale->fresh(['items', 'payments']);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a refund sale record
     */
    protected function createRefundSale(PosSale $originalSale, array $refundItems, array $data): PosSale
    {
        // Calculate refund totals
        $subtotal = 0;
        foreach ($refundItems as $item) {
            if (is_array($item)) {
                $subtotal += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0);
            } else {
                $subtotal += $item->line_total;
            }
        }

        // Apply proportional discount if original had discount
        $discountValue = 0;
        if ($originalSale->discount_value > 0 && $originalSale->subtotal > 0) {
            $discountRatio = $originalSale->discount_value / $originalSale->subtotal;
            $discountValue = $subtotal * $discountRatio;
        }

        // Calculate tax
        $taxableAmount = $subtotal - $discountValue;
        $taxRate = $originalSale->tax_rate;
        $taxAmount = ($taxableAmount * $taxRate) / 100;
        $totalAmount = $taxableAmount + $taxAmount;

        // Create refund sale
        $refundSale = PosSale::create([
            'merchant_id' => $originalSale->merchant_id,
            'customer_id' => $originalSale->customer_id,
            'sale_number' => $this->generateRefundNumber($originalSale->sale_number),
            'sale_type' => 'refund',
            'status' => 'completed',
            'subtotal' => $subtotal,
            'discount_type' => $originalSale->discount_type,
            'discount_amount' => $originalSale->discount_amount,
            'discount_value' => $discountValue,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'paid_amount' => $totalAmount,
            'notes' => $data['reason'] ?? 'Refund for sale ' . $originalSale->sale_number,
            'created_by' => auth()->id(),
            'completed_at' => now(),
        ]);

        // Create refund sale items
        foreach ($refundItems as $itemData) {
            if (is_array($itemData)) {
                PosSaleItem::create([
                    'pos_sale_id' => $refundSale->id,
                    'product_id' => $itemData['product_id'],
                    'product_variation_id' => $itemData['product_variation_id'] ?? null,
                    'product_name' => $itemData['product_name'],
                    'variation_name' => $itemData['variation_name'] ?? null,
                    'sku' => $itemData['sku'] ?? null,
                    'barcode' => $itemData['barcode'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'unit_cost' => $itemData['unit_cost'] ?? 0,
                    'line_total' => $itemData['unit_price'] * $itemData['quantity'],
                ]);
            } else {
                // From original item object
                PosSaleItem::create([
                    'pos_sale_id' => $refundSale->id,
                    'product_id' => $itemData->product_id,
                    'product_variation_id' => $itemData->product_variation_id,
                    'product_name' => $itemData->product_name,
                    'variation_name' => $itemData->variation_name,
                    'sku' => $itemData->sku,
                    'barcode' => $itemData->barcode,
                    'quantity' => $itemData->quantity,
                    'unit_price' => $itemData->unit_price,
                    'unit_cost' => $itemData->unit_cost,
                    'line_total' => $itemData->line_total,
                ]);
            }
        }

        return $refundSale;
    }

    /**
     * Restore inventory for refunded item
     */
    protected function restoreInventory(PosSaleItem $item, int $quantity, PosSale $refundSale): void
    {
        // Use inventory service to restore stock
        $this->inventoryService->restoreStock(
            $item->product_id,
            $item->product_variation_id,
            $quantity,
            $item->unit_cost,
            [
                'type' => 'pos_sales',
                'id' => $refundSale->id,
            ]
        );
    }

    /**
     * Process refund payments (reverse original payments)
     */
    protected function processRefundPayments(PosSale $originalSale, PosSale $refundSale): void
    {
        // Get original payments
        $originalPayments = $originalSale->payments;

        foreach ($originalPayments as $originalPayment) {
            PosPayment::create([
                'merchant_id' => $refundSale->merchant_id,
                'pos_sale_id' => $refundSale->id,
                'payment_method' => $originalPayment->payment_method,
                'amount' => $originalPayment->amount,
                'is_refund' => true,
                'original_payment_id' => $originalPayment->id,
                'reference_number' => 'REFUND-' . $originalPayment->id,
                'processed_by' => auth()->id(),
            ]);
        }
    }

    /**
     * Process proportional refund for partial returns
     */
    protected function processProportionalRefund(PosSale $originalSale, PosSale $refundSale, float $refundAmount): void
    {
        $originalPayments = $originalSale->payments;
        $totalPaid = $originalSale->paid_amount;

        if ($totalPaid <= 0) {
            return;
        }

        foreach ($originalPayments as $originalPayment) {
            // Calculate proportional refund for this payment method
            $ratio = $originalPayment->amount / $totalPaid;
            $paymentRefundAmount = $refundAmount * $ratio;

            PosPayment::create([
                'merchant_id' => $refundSale->merchant_id,
                'pos_sale_id' => $refundSale->id,
                'payment_method' => $originalPayment->payment_method,
                'amount' => $paymentRefundAmount,
                'is_refund' => true,
                'original_payment_id' => $originalPayment->id,
                'reference_number' => 'REFUND-' . $originalPayment->id,
                'processed_by' => auth()->id(),
            ]);
        }
    }

    /**
     * Validate refund items
     */
    protected function validateRefundItems(PosSale $sale, array $refundItems): void
    {
        foreach ($refundItems as $itemData) {
            $itemId = $itemData['id'] ?? null;
            $quantity = $itemData['quantity'] ?? 0;

            if (!$itemId || $quantity <= 0) {
                throw new Exception('Invalid refund item data');
            }

            $originalItem = $sale->items->find($itemId);
            if (!$originalItem) {
                throw new Exception("Item {$itemId} not found in original sale");
            }

            if ($quantity > $originalItem->quantity) {
                throw new Exception("Refund quantity exceeds original quantity for {$originalItem->product_name}");
            }
        }
    }

    /**
     * Generate refund sale number
     */
    protected function generateRefundNumber(string $originalNumber): string
    {
        return 'RF-' . $originalNumber;
    }

    /**
     * Check if sale can be refunded
     */
    public function canRefund(PosSale $sale): bool
    {
        return $sale->status === 'completed' && $sale->sale_type !== 'refund';
    }

    /**
     * Get refundable items from a sale
     */
    public function getRefundableItems(PosSale $sale): array
    {
        if (!$this->canRefund($sale)) {
            return [];
        }

        return $sale->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_variation_id' => $item->product_variation_id,
                'product_name' => $item->product_name,
                'variation_name' => $item->variation_name,
                'quantity' => $item->quantity,
                'max_refund_quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'line_total' => $item->line_total,
            ];
        })->toArray();
    }
}
