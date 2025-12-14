<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PartnerSettlementService;
use App\Services\PartnerProfitService;
use Carbon\Carbon;

class GeneratePartnerSettlements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partners:generate-settlements {year?} {month?} {--force : Force regeneration even if settlements are already paid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate partner profit sharing settlements for a specific month';

    /**
     * @var PartnerSettlementService
     */
    protected $settlementService;

    /**
     * Create a new command instance.
     *
     * @param PartnerSettlementService $settlementService
     */
    public function __construct(PartnerSettlementService $settlementService)
    {
        parent::__construct();
        $this->settlementService = $settlementService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = (int) $this->argument('year');
        $month = $this->argument('month') ?? Carbon::now()->month;
        $force = $this->option('force');

        // Validate inputs
        if ($year < 2020 || $year > 2100) {
            $this->error('Year must be between 2020 and 2100');
            return 1;
        }

        if ($month < 1 || $month > 12) {
            $this->error('Month must be between 1 and 12');
            return 1;
        }

        $period = "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT);

        $this->info("Generating partner settlements for: {$period}");

        if ($force) {
            $this->warn('Force mode enabled - existing settlements will be replaced');
        }

        try {
            // Check if settlements already exist
            $existingCount = \App\Models\PartnerMonthlySettlement::where('period_year', $year)
                ->where('period_month', $month)
                ->count();

            if ($existingCount > 0 && !$force) {
                $this->warn("Settlements already exist for {$period}");
                if (!$this->confirm('Do you want to regenerate them? Use --force to bypass this prompt.')) {
                    $this->info('Operation cancelled');
                    return 0;
                }
            }

            // Generate settlements
            $results = $force
                ? $this->settlementService->regenerateForMonth($year, $month, true)
                : $this->settlementService->generateForMonth($year, $month);

            // Display results
            $this->displayResults($results, $period);

            // Show profit breakdown
            $this->showProfitBreakdown($year, $month);

            return 0;

        } catch (\Exception $e) {
            $this->error("Error generating settlements: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Display settlement generation results.
     *
     * @param array $results
     * @param string $period
     */
    private function displayResults($results, $period)
    {
        $this->info("\n=== Settlement Generation Results for {$period} ===");

        $successCount = 0;
        $errorCount = 0;
        $totalAmount = 0;

        foreach ($results as $result) {
            if ($result['status'] === 'success') {
                $successCount++;
                $totalAmount += $result['amount'];
                $this->line("✓ {$result['partner']}: {$result['amount']} (ID: {$result['settlement_id']})");
            } else {
                $errorCount++;
                $this->error("✗ {$result['partner']}: {$result['message']}");
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->line("  Successful: {$successCount}");
        $this->line("  Failed: {$errorCount}");
        $this->line("  Total Partner Amount: {$totalAmount}");
    }

    /**
     * Show profit breakdown for the period.
     *
     * @param int $year
     * @param int $month
     */
    private function showProfitBreakdown($year, $month)
    {
        $summary = $this->settlementService->getMonthlySummary($year, $month);
        $profitData = $summary['profit_data'];

        $this->newLine();
        $this->info("=== Profit Breakdown for {$profitData['period']} ===");
        $this->line("  Collected Revenue: {$profitData['collected_revenue']}");
        $this->line("  COGS: {$profitData['cogs']}");
        $this->line("  Expenses: {$profitData['expenses']}");
        $this->line("  Refunds: {$profitData['refunds']}");
        $this->line("  Net Profit: {$profitData['net_profit']}");
        $this->line("  Total Partner Amount: {$summary['total_partner_amount']}");
        $this->line("  Pending Amount: {$summary['total_pending']}");
        $this->line("  Paid Amount: {$summary['total_paid']}");
    }
}
