<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerMonthlySettlement;
use App\Services\PartnerSettlementService;
use App\Services\PartnerProfitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerController extends Controller
{
    protected $settlementService;
    protected $profitService;

    public function __construct(PartnerSettlementService $settlementService, PartnerProfitService $profitService)
    {
        $this->settlementService = $settlementService;
        $this->profitService = $profitService;
    }

    /**
     * Display a listing of partners.
     */
    public function index()
    {
        $partners = Partner::withCount('monthlySettlements')
            ->withSum('monthlySettlements as total_amount', 'partner_amount')
            ->orderBy('name')
            ->paginate(15);

        return response()->json([
            'data' => $partners->items(),
            'pagination' => [
                'total' => $partners->total(),
                'per_page' => $partners->perPage(),
                'current_page' => $partners->currentPage(),
                'last_page' => $partners->lastPage(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return response()->json(['message' => 'Create partner form']);
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profit_percent' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $partner = Partner::create($validated);

        return response()->json([
            'message' => 'Partner created successfully.',
            'partner' => $partner
        ]);
    }

    /**
     * Display the specified partner.
     */
    public function show(Request $request)
    {
        $partnerId = $request->input('id');
        $partner = Partner::with(['monthlySettlements' => function($query) {
            $query->orderBy('period_year', 'desc')
                  ->orderBy('period_month', 'desc');
        }])->findOrFail($partnerId);

        $totalPaid = $partner->monthlySettlements->where('status', 'paid')->sum('partner_amount');
        $totalPending = $partner->monthlySettlements->where('status', 'pending')->sum('partner_amount');

        return response()->json([
            'partner' => $partner,
            'total_paid' => $totalPaid,
            'total_pending' => $totalPending
        ]);
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return response()->json(['partner' => $partner]);
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profit_percent' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $partner->update($validated);

        return response()->json([
            'message' => 'Partner updated successfully.',
            'partner' => $partner
        ]);
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy(Partner $partner)
    {
        // Check if partner has settlements
        if ($partner->monthlySettlements()->exists()) {
            return response()->json([
                'error' => 'Cannot delete partner with existing settlements.'
            ], 422);
        }

        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully.'
        ]);
    }

    /**
     * Display settlements for a partner.
     */
    public function settlements(Request $request)
    {
        $partnerId = $request->input('id');
        $partner = Partner::findOrFail($partnerId);

        $settlements = $partner->monthlySettlements()
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->paginate(20);

        return response()->json([
            'partner' => $partner,
            'settlements' => $settlements->items(),
            'pagination' => [
                'total' => $settlements->total(),
                'per_page' => $settlements->perPage(),
                'current_page' => $settlements->currentPage(),
                'last_page' => $settlements->lastPage(),
            ]
        ]);
    }

    /**
     * Generate settlements for a specific month.
     */
    public function generateSettlements(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'force' => 'boolean',
        ]);

        try {
            $results = $request->has('force')
                ? $this->settlementService->regenerateForMonth(
                    $validated['year'],
                    $validated['month'],
                    true
                )
                : $this->settlementService->generateForMonth(
                    $validated['year'],
                    $validated['month']
                );

            return response()->json([
                'message' => 'Settlements generated successfully.',
                'results' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error generating settlements: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Mark a settlement as paid.
     */
    public function markSettlementPaid(PartnerMonthlySettlement $settlement)
    {
        try {
            $this->settlementService->markPaid($settlement->id);

            return response()->json([
                'message' => 'Settlement marked as paid successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error marking settlement as paid: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display all settlements.
     */
    public function allSettlements(Request $request)
    {
        $query = PartnerMonthlySettlement::with('partner')
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc');

        // Filter by year if provided
        if ($request->has('year')) {
            $query->where('period_year', $request->year);
        }

        // Filter by month if provided
        if ($request->has('month')) {
            $query->where('period_month', $request->month);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $settlements = $query->paginate(25);

        // Get available years for filter
        $years = PartnerMonthlySettlement::distinct()
            ->orderBy('period_year', 'desc')
            ->pluck('period_year');

        return response()->json([
            'data' => $settlements->items(),
            'years' => $years,
            'total_amount' => $settlements->sum('partner_amount'),
            'total_pending' => $settlements->where('status', 'pending')->sum('partner_amount'),
            'total_paid' => $settlements->where('status', 'paid')->sum('partner_amount'),
            'pagination' => [
                'total' => $settlements->total(),
                'per_page' => $settlements->perPage(),
                'current_page' => $settlements->currentPage(),
                'last_page' => $settlements->lastPage(),
            ]
        ]);
    }

    /**
     * Show profit breakdown for a specific month.
     */
    public function profitBreakdown($year, $month)
    {
        $profitData = $this->profitService->computeNetProfitForMonth($year, $month);
        $breakdown = $this->profitService->getProfitBreakdown(
            Carbon::create($year, $month, 1)->startOfDay(),
            Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()
        );

        return response()->json([
            'profit_data' => $profitData,
            'breakdown' => $breakdown,
            'year' => $year,
            'month' => $month
        ]);
    }
}
