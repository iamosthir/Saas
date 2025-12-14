<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InstallmentSchedule;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerProfitService
{
    /**
     * Calculate net profit for a specific month.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public function computeNetProfitForMonth($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        $collectedRevenue = $this->computeCollectedRevenue($startDate, $endDate);
        $cogs = $this->computeCogsCashBasisProportional($startDate, $endDate);
        $expenses = $this->computeMonthlyExpenses($year, $month);
        $refunds = $this->computeMonthlyRefunds($startDate, $endDate);

        $netProfit = $collectedRevenue - $cogs - $expenses - $refunds;

        return [
            'period' => "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT),
            'collected_revenue' => $collectedRevenue,
            'cogs' => $cogs,
            'expenses' => $expenses,
            'refunds' => $refunds,
            'net_profit' => max(0, $netProfit), // Net profit cannot be negative for partner calculations
        ];
    }

    /**
     * Calculate collected revenue for a period (cash basis).
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return float
     */
    public function computeCollectedRevenue($startDate, $endDate)
    {
        return InstallmentSchedule::where('status', 'paid')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->sum('paid_amount');
    }

    /**
     * Calculate COGS using cash-basis proportional method.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return float
     */
    public function computeCogsCashBasisProportional($startDate, $endDate)
    {
        $totalCogs = 0;

        // Get all invoices that received payments during the period
        $invoicesWithPayments = InstallmentSchedule::where('status', 'paid')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->pluck('invoice_id')
            ->unique();

        foreach ($invoicesWithPayments as $invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) continue;

            // Calculate total collected for this invoice during the period
            $collectedInMonth = InstallmentSchedule::where('invoice_id', $invoiceId)
                ->where('status', 'paid')
                ->whereBetween('paid_date', [$startDate, $endDate])
                ->sum('paid_amount');

            // Calculate total COGS for this invoice
            $saleCogsTotal = $this->calculateSaleCogsTotal($invoice);

            // Calculate proportional COGS for the month
            if ($invoice->total_amount > 0) {
                $proportionalCogs = $saleCogsTotal * ($collectedInMonth / $invoice->total_amount);
                $totalCogs += $proportionalCogs;
            }
        }

        return $totalCogs;
    }

    /**
     * Calculate total COGS for a sale/invoice.
     *
     * @param Invoice $invoice
     * @return float
     */
    private function calculateSaleCogsTotal($invoice)
    {
        $totalCogs = 0;

        foreach ($invoice->items as $item) {
            // Use the unit_cost snapshot if available
            if ($item->unit_cost > 0) {
                $totalCogs += $item->unit_cost * $item->quantity;
            } else {
                // Fallback: try to get cost from variation or product
                // This should only happen for historical data before unit_cost was implemented
                if ($item->product_variation_id && $item->productVariation) {
                    $totalCogs += $item->productVariation->purchase_price * $item->quantity;
                } elseif ($item->product && $item->product->purchase_price > 0) {
                    $totalCogs += $item->product->purchase_price * $item->quantity;
                }
            }
        }

        return $totalCogs;
    }

    /**
     * Calculate total expenses for a month.
     *
     * @param int $year
     * @param int $month
     * @return float
     */
    public function computeMonthlyExpenses($year, $month)
    {
        return Expense::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
    }

    /**
     * Calculate total refunds for a month.
     * Note: This is a placeholder implementation as there's no refund table in the current schema.
     * This can be extended when a refund system is implemented.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return float
     */
    public function computeMonthlyRefunds($startDate, $endDate)
    {
        // TODO: Implement when refund/cancellation tables are added
        // For now, return 0 as there's no refund table in the current schema
        return 0;

        // Example implementation when refund table exists:
        // return Refund::whereBetween('refund_date', [$startDate, $endDate])
        //     ->sum('refund_amount');
    }

    /**
     * Get profit breakdown for all invoices with payments in a period.
     * Useful for debugging and reporting.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function getProfitBreakdown($startDate, $endDate)
    {
        $breakdown = [];

        $invoicesWithPayments = InstallmentSchedule::where('status', 'paid')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->pluck('invoice_id')
            ->unique();

        foreach ($invoicesWithPayments as $invoiceId) {
            $invoice = Invoice::with('items.product', 'items.productVariation')->find($invoiceId);
            if (!$invoice) continue;

            $collectedInMonth = InstallmentSchedule::where('invoice_id', $invoiceId)
                ->where('status', 'paid')
                ->whereBetween('paid_date', [$startDate, $endDate])
                ->sum('paid_amount');

            $saleCogsTotal = $this->calculateSaleCogsTotal($invoice);
            $proportionalCogs = $invoice->total_amount > 0
                ? $saleCogsTotal * ($collectedInMonth / $invoice->total_amount)
                : 0;

            $breakdown[] = [
                'invoice_number' => $invoice->invoice_number,
                'invoice_total' => $invoice->total_amount,
                'collected_in_month' => $collectedInMonth,
                'sale_cogs_total' => $saleCogsTotal,
                'proportional_cogs' => $proportionalCogs,
                'profit_contribution' => $collectedInMonth - $proportionalCogs,
            ];
        }

        return $breakdown;
    }
}
