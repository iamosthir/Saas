<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\PartnerMonthlySettlement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PartnerSettlementService
{
    protected $profitService;

    public function __construct(PartnerProfitService $profitService)
    {
        $this->profitService = $profitService;
    }

    /**
     * Generate settlements for all active partners for a specific month.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public function generateForMonth($year, $month)
    {
        $results = [];
        $startDate = Carbon::create($year, $month, 1);

        // Calculate net profit for the month
        $profitData = $this->profitService->computeNetProfitForMonth($year, $month);
        $netProfit = $profitData['net_profit'];

        // Get all active partners
        $partners = Partner::active()->get();

        DB::transaction(function () use ($partners, $year, $month, $netProfit, &$results) {
            foreach ($partners as $partner) {
                try {
                    $settlement = $this->generatePartnerSettlement($partner, $year, $month, $netProfit);
                    $results[] = [
                        'partner' => $partner->name,
                        'status' => 'success',
                        'settlement_id' => $settlement->id,
                        'amount' => $settlement->partner_amount,
                    ];
                } catch (\Exception $e) {
                    Log::error("Failed to generate settlement for partner {$partner->id}: " . $e->getMessage());
                    $results[] = [
                        'partner' => $partner->name,
                        'status' => 'error',
                        'message' => $e->getMessage(),
                    ];
                }
            }
        });

        return $results;
    }

    /**
     * Generate settlement for a specific partner.
     *
     * @param Partner $partner
     * @param int $year
     * @param int $month
     * @param float $netProfit
     * @return PartnerMonthlySettlement
     */
    private function generatePartnerSettlement($partner, $year, $month, $netProfit)
    {
        // Calculate partner payout
        $partnerAmount = $this->calculatePartnerPayout($netProfit, $partner->profit_percent);

        // Upsert settlement to ensure idempotency
        return PartnerMonthlySettlement::updateOrCreate(
            [
                'partner_id' => $partner->id,
                'period_year' => $year,
                'period_month' => $month,
            ],
            [
                'net_profit' => $netProfit,
                'partner_percent' => $partner->profit_percent,
                'partner_amount' => $partnerAmount,
                'status' => 'pending',
                'generated_at' => now(),
                'notes' => $netProfit <= 0 ? 'No profit generated for this period' : null,
            ]
        );
    }

    /**
     * Calculate partner payout based on net profit and percentage.
     *
     * @param float $netProfit
     * @param float $partnerPercent
     * @return float
     */
    private function calculatePartnerPayout($netProfit, $partnerPercent)
    {
        // If net profit is zero or negative, partner gets nothing
        if ($netProfit <= 0) {
            return 0;
        }

        return $netProfit * ($partnerPercent / 100);
    }

    /**
     * Mark a settlement as paid.
     *
     * @param int $settlementId
     * @return bool
     */
    public function markPaid($settlementId)
    {
        $settlement = PartnerMonthlySettlement::findOrFail($settlementId);

        if ($settlement->isPaid()) {
            return false; // Already paid
        }

        $settlement->markAsPaid();
        return true;
    }

    /**
     * Regenerate settlements for a specific month.
     * This will replace existing settlements with new calculations.
     *
     * @param int $year
     * @param int $month
     * @param bool $force
     * @return array
     */
    public function regenerateForMonth($year, $month, $force = false)
    {
        // Check if there are already paid settlements
        $paidSettlements = PartnerMonthlySettlement::where('period_year', $year)
            ->where('period_month', $month)
            ->where('status', 'paid')
            ->count();

        if ($paidSettlements > 0 && !$force) {
            throw new \Exception("Cannot regenerate settlements for {$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . " because some settlements are already paid. Use force=true to override.");
        }

        // Delete existing settlements for the month
        PartnerMonthlySettlement::where('period_year', $year)
            ->where('period_month', $month)
            ->delete();

        // Generate new settlements
        return $this->generateForMonth($year, $month);
    }

    /**
     * Get settlement summary for a month.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public function getMonthlySummary($year, $month)
    {
        $settlements = PartnerMonthlySettlement::with('partner')
            ->where('period_year', $year)
            ->where('period_month', $month)
            ->get();

        $profitData = $this->profitService->computeNetProfitForMonth($year, $month);

        return [
            'period' => "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT),
            'profit_data' => $profitData,
            'total_partner_amount' => $settlements->sum('partner_amount'),
            'total_pending' => $settlements->where('status', 'pending')->sum('partner_amount'),
            'total_paid' => $settlements->where('status', 'paid')->sum('partner_amount'),
            'settlements' => $settlements,
            'settlement_count' => $settlements->count(),
        ];
    }

    /**
     * Generate settlements for multiple months.
     *
     * @param array $periods Array of ['year' => int, 'month' => int]
     * @return array
     */
    public function generateForMultipleMonths($periods)
    {
        $results = [];

        foreach ($periods as $period) {
            try {
                $monthResults = $this->generateForMonth($period['year'], $period['month']);
                $results[$period['year'] . '-' . str_pad($period['month'], 2, '0', STR_PAD_LEFT)] = $monthResults;
            } catch (\Exception $e) {
                $results[$period['year'] . '-' . str_pad($period['month'], 2, '0', STR_PAD_LEFT)] = [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }
}
