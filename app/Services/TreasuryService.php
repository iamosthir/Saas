<?php

namespace App\Services;

use App\Models\TreasuryTransaction;
use App\Models\TreasurySummary;
use Carbon\Carbon;

class TreasuryService
{
    /**
     * Record a treasury transaction
     */
    public function recordTransaction($type, $category, $amount, $description, $transactionable = null)
    {
        $transaction = TreasuryTransaction::create([
            'merchant_id' => auth()->user()->merchant_id,
            'type' => $type,
            'category' => $category,
            'amount' => $amount,
            'description' => $description,
            'transactionable_id' => $transactionable ? $transactionable->id : null,
            'transactionable_type' => $transactionable ? get_class($transactionable) : null,
            'transaction_date' => now()->toDateString(),
        ]);

        // Update monthly summary
        $this->updateMonthlySummary(now()->year, now()->month);

        return $transaction;
    }

    /**
     * Update monthly summary for a given month
     */
    public function updateMonthlySummary($year, $month)
    {
        $merchantId = auth()->user()->merchant_id;

        // Get or create summary
        $summary = TreasurySummary::firstOrCreate(
            [
                'merchant_id' => $merchantId,
                'year' => $year,
                'month' => $month,
            ],
            [
                'opening_balance' => $this->getPreviousClosingBalance($year, $month, $merchantId),
                'total_income' => 0,
                'total_expense' => 0,
                'closing_balance' => 0,
            ]
        );

        // Calculate totals for the month
        $income = TreasuryTransaction::where('merchant_id', $merchantId)
            ->income()
            ->forMonth($year, $month)
            ->sum('amount');

        $expense = TreasuryTransaction::where('merchant_id', $merchantId)
            ->expense()
            ->forMonth($year, $month)
            ->sum('amount');

        // Update summary
        $summary->total_income = $income;
        $summary->total_expense = $expense;
        $summary->calculateBalance();
        $summary->save();

        return $summary;
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        $merchantId = auth()->user()->merchant_id;
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Current month stats
        $currentMonthIncome = TreasuryTransaction::where('merchant_id', $merchantId)
            ->income()
            ->forMonth($currentYear, $currentMonth)
            ->sum('amount');

        $currentMonthExpense = TreasuryTransaction::where('merchant_id', $merchantId)
            ->expense()
            ->forMonth($currentYear, $currentMonth)
            ->sum('amount');

        // Year to date stats
        $ytdIncome = TreasuryTransaction::where('merchant_id', $merchantId)
            ->income()
            ->forYear($currentYear)
            ->sum('amount');

        $ytdExpense = TreasuryTransaction::where('merchant_id', $merchantId)
            ->expense()
            ->forYear($currentYear)
            ->sum('amount');

        // Current balance (latest closing balance)
        $latestSummary = TreasurySummary::where('merchant_id', $merchantId)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->first();

        $currentBalance = $latestSummary ? $latestSummary->closing_balance : 0;

        return [
            'current_month_income' => $currentMonthIncome,
            'current_month_expense' => $currentMonthExpense,
            'current_month_net' => $currentMonthIncome - $currentMonthExpense,
            'ytd_income' => $ytdIncome,
            'ytd_expense' => $ytdExpense,
            'ytd_net' => $ytdIncome - $ytdExpense,
            'current_balance' => $currentBalance,
        ];
    }

    /**
     * Get transaction history with filters
     */
    public function getTransactionHistory($filters = [])
    {
        $merchantId = auth()->user()->merchant_id;
        $query = TreasuryTransaction::where('merchant_id', $merchantId);

        // Apply filters
        if (isset($filters['type']) && in_array($filters['type'], ['income', 'expense'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['date_from'])) {
            $query->where('transaction_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('transaction_date', '<=', $filters['date_to']);
        }

        if (isset($filters['year']) && isset($filters['month'])) {
            $query->forMonth($filters['year'], $filters['month']);
        }

        return $query->orderBy('transaction_date', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get previous month's closing balance
     */
    private function getPreviousClosingBalance($year, $month, $merchantId)
    {
        $previousMonth = Carbon::create($year, $month, 1)->subMonth();

        $previousSummary = TreasurySummary::where('merchant_id', $merchantId)
            ->where('year', $previousMonth->year)
            ->where('month', $previousMonth->month)
            ->first();

        return $previousSummary ? $previousSummary->closing_balance : 0;
    }
}
