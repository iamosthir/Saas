<?php

namespace App\Services\Pos;

use App\Models\Pos\PosPayment;
use App\Models\Pos\PosSale;
use App\Models\Pos\PosSetting;

class PosPaymentService
{
    protected PosPricingService $pricingService;

    public function __construct(PosPricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Process a single payment
     */
    public function processPayment(PosSale $sale, array $paymentData): PosPayment
    {
        $settings = PosSetting::getForMerchant($sale->merchant_id);

        // Validate payment method is enabled
        if (!$settings->isPaymentMethodEnabled($paymentData['payment_method'])) {
            throw new \Exception("Payment method '{$paymentData['payment_method']}' is not enabled");
        }

        // Calculate change for cash payments
        $amount = $paymentData['amount'];
        $tenderedAmount = $paymentData['tendered_amount'] ?? null;
        $changeGiven = 0;

        if ($paymentData['payment_method'] === 'cash' && $tenderedAmount !== null) {
            $remainingToPay = $sale->total_amount - $sale->paid_amount;
            $changeGiven = $this->pricingService->calculateChange($remainingToPay, $tenderedAmount);
            // Actual amount is what was needed, not what was tendered
            $amount = min($tenderedAmount, $remainingToPay);
        }

        return PosPayment::create([
            'merchant_id' => $sale->merchant_id,
            'pos_sale_id' => $sale->id,
            'payment_method' => $paymentData['payment_method'],
            'amount' => $amount,
            'tendered_amount' => $tenderedAmount,
            'change_given' => $changeGiven,
            'reference_number' => $paymentData['reference_number'] ?? null,
            'metadata' => $paymentData['metadata'] ?? null,
        ]);
    }

    /**
     * Process split payment (multiple payment methods)
     */
    public function processSplitPayment(PosSale $sale, array $payments): array
    {
        $processedPayments = [];
        $totalPaid = 0;

        foreach ($payments as $paymentData) {
            $payment = $this->processPayment($sale, $paymentData);
            $processedPayments[] = $payment;
            $totalPaid += $payment->amount;
        }

        // Validate total paid covers sale amount
        if ($totalPaid < $sale->total_amount) {
            throw new \Exception("Total payment ({$totalPaid}) is less than sale amount ({$sale->total_amount})");
        }

        return $processedPayments;
    }

    /**
     * Calculate remaining amount to pay
     */
    public function getRemainingAmount(PosSale $sale): float
    {
        $totalPaid = $sale->payments()->sum('amount');
        return max(0, $sale->total_amount - $totalPaid);
    }

    /**
     * Get payment summary for a sale
     */
    public function getPaymentSummary(PosSale $sale): array
    {
        $payments = $sale->payments;

        $summary = [
            'total_amount' => $sale->total_amount,
            'total_paid' => $payments->sum('amount'),
            'total_change' => $payments->sum('change_given'),
            'remaining' => 0,
            'by_method' => [],
        ];

        $summary['remaining'] = max(0, $summary['total_amount'] - $summary['total_paid']);

        // Group by payment method
        foreach ($payments as $payment) {
            $method = $payment->payment_method;
            if (!isset($summary['by_method'][$method])) {
                $summary['by_method'][$method] = [
                    'count' => 0,
                    'amount' => 0,
                ];
            }
            $summary['by_method'][$method]['count']++;
            $summary['by_method'][$method]['amount'] += $payment->amount;
        }

        return $summary;
    }

    /**
     * Validate payment data
     */
    public function validatePayment(array $paymentData): array
    {
        $errors = [];

        if (empty($paymentData['payment_method'])) {
            $errors[] = 'Payment method is required';
        }

        if (!isset($paymentData['amount']) || $paymentData['amount'] <= 0) {
            $errors[] = 'Payment amount must be greater than zero';
        }

        $validMethods = ['cash', 'card', 'wallet', 'bank_transfer', 'other'];
        if (!empty($paymentData['payment_method']) && !in_array($paymentData['payment_method'], $validMethods)) {
            $errors[] = 'Invalid payment method';
        }

        return $errors;
    }

    /**
     * Get quick payment amounts for cash
     */
    public function getQuickCashAmounts(float $totalAmount): array
    {
        $amounts = [];

        // Exact amount
        $amounts[] = $totalAmount;

        // Round up to common denominations
        $denominations = [5, 10, 20, 50, 100, 200, 500, 1000];

        foreach ($denominations as $denom) {
            if ($denom > $totalAmount) {
                $amounts[] = $denom;
                if (count($amounts) >= 6) break;
            }
        }

        return array_unique($amounts);
    }
}
