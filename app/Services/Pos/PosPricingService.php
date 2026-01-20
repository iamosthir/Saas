<?php

namespace App\Services\Pos;

class PosPricingService
{
    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $subtotal, ?string $discountType, float $discountAmount): float
    {
        if (!$discountType || $discountAmount <= 0) {
            return 0;
        }

        if ($discountType === 'percentage') {
            // Ensure percentage doesn't exceed 100%
            $percentage = min($discountAmount, 100);
            return ($subtotal * $percentage) / 100;
        }

        // Fixed discount - ensure it doesn't exceed subtotal
        return min($discountAmount, $subtotal);
    }

    /**
     * Calculate tax amount
     */
    public function calculateTax(float $amount, float $taxRate): float
    {
        if ($taxRate <= 0) {
            return 0;
        }

        return ($amount * $taxRate) / 100;
    }

    /**
     * Calculate line total with item discount
     */
    public function calculateLineTotal(
        int $quantity,
        float $unitPrice,
        ?string $discountType = null,
        float $discountAmount = 0
    ): array {
        $subtotal = $quantity * $unitPrice;
        $discountValue = $this->calculateDiscount($subtotal, $discountType, $discountAmount);
        $lineTotal = $subtotal - $discountValue;

        return [
            'subtotal' => $subtotal,
            'discount_value' => $discountValue,
            'line_total' => $lineTotal,
        ];
    }

    /**
     * Calculate sale totals
     */
    public function calculateSaleTotals(
        float $itemsSubtotal,
        ?string $saleDiscountType,
        float $saleDiscountAmount,
        float $taxRate
    ): array {
        $discountValue = $this->calculateDiscount($itemsSubtotal, $saleDiscountType, $saleDiscountAmount);
        $taxableAmount = $itemsSubtotal - $discountValue;
        $taxAmount = $this->calculateTax($taxableAmount, $taxRate);
        $total = $taxableAmount + $taxAmount;

        return [
            'subtotal' => $itemsSubtotal,
            'discount_value' => $discountValue,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
        ];
    }

    /**
     * Calculate change for cash payment
     */
    public function calculateChange(float $totalAmount, float $tenderedAmount): float
    {
        if ($tenderedAmount <= $totalAmount) {
            return 0;
        }

        return $tenderedAmount - $totalAmount;
    }

    /**
     * Round to currency precision (2 decimal places)
     */
    public function round(float $amount): float
    {
        return round($amount, 2);
    }

    /**
     * Format currency for display
     */
    public function formatCurrency(float $amount, string $currencySymbol = '$'): string
    {
        return $currencySymbol . number_format($amount, 2);
    }
}
