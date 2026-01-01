<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TreasuryService;
use App\Models\TreasuryTransaction;
use App\Models\TreasurySummary;
use Illuminate\Support\Facades\Auth;

class TreasuryController extends Controller
{
    protected $treasuryService;

    public function __construct(TreasuryService $treasuryService)
    {
        $this->treasuryService = $treasuryService;
    }

    /**
     * Dashboard with stats cards
     */
    public function index()
    {
        $stats = $this->treasuryService->getDashboardStats();

        return response()->json([
            'status' => 'ok',
            'stats' => $stats,
        ]);
    }

    /**
     * Transaction list with filters
     */
    public function transactions(Request $request)
    {
        $filters = $request->validate([
            'type' => 'nullable|in:income,expense',
            'category' => 'nullable|in:invoice_payment,deposit,installment,expense,refund,other',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'year' => 'nullable|integer|min:2020',
            'month' => 'nullable|integer|min:1|max:12',
            'per_page' => 'nullable|integer|min:5|max:100',
        ]);

        $transactions = $this->treasuryService->getTransactionHistory($filters);

        return response()->json([
            'status' => 'ok',
            'transactions' => $transactions,
        ]);
    }

    /**
     * Monthly/yearly reports
     */
    public function report(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $merchantId = Auth::user()->merchant_id;

        if ($request->month) {
            // Monthly report
            $summary = TreasurySummary::where('merchant_id', $merchantId)
                ->where('year', $request->year)
                ->where('month', $request->month)
                ->first();

            if ($summary) {
                $report = $summary->getMonthlyReport();

                // Get transactions for this month
                $transactions = TreasuryTransaction::where('merchant_id', $merchantId)
                    ->forMonth($request->year, $request->month)
                    ->orderBy('transaction_date', 'desc')
                    ->get();

                return response()->json([
                    'status' => 'ok',
                    'report' => $report,
                    'transactions' => $transactions,
                ]);
            } else {
                return response()->json([
                    'status' => 'ok',
                    'report' => null,
                    'message' => 'No data for this period',
                ]);
            }
        } else {
            // Yearly report
            $summaries = TreasurySummary::where('merchant_id', $merchantId)
                ->where('year', $request->year)
                ->orderBy('month')
                ->get();

            $monthlyData = $summaries->map(function ($summary) {
                return $summary->getMonthlyReport();
            });

            $yearlyTotals = [
                'total_income' => $summaries->sum('total_income'),
                'total_expense' => $summaries->sum('total_expense'),
                'net_change' => $summaries->sum('total_income') - $summaries->sum('total_expense'),
                'opening_balance' => $summaries->first()->opening_balance ?? 0,
                'closing_balance' => $summaries->last()->closing_balance ?? 0,
            ];

            return response()->json([
                'status' => 'ok',
                'yearly_totals' => $yearlyTotals,
                'monthly_data' => $monthlyData,
            ]);
        }
    }

    /**
     * Export treasury report (placeholder - actual Excel export would require package)
     */
    public function export(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020',
            'month' => 'nullable|integer|min:1|max:12',
            'type' => 'nullable|in:income,expense',
        ]);

        $merchantId = Auth::user()->merchant_id;

        $query = TreasuryTransaction::where('merchant_id', $merchantId);

        if ($request->month) {
            $query->forMonth($request->year, $request->month);
        } else {
            $query->forYear($request->year);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        // For now, return JSON. In production, you would use Laravel Excel package
        return response()->json([
            'status' => 'ok',
            'data' => $transactions,
            'message' => 'Export data retrieved. Implement Excel export using maatwebsite/excel package.',
        ]);
    }
}
