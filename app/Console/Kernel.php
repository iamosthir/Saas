<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Generate partner settlements on the 1st day of each month at 2:00 AM
        // This generates settlements for the previous month
        $schedule->command('partners:generate-settlements ' . now()->subMonth()->year . ' ' . now()->subMonth()->month)
            ->monthlyOn(1, '02:00')
            ->timezone('Asia/Dhaka')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/partner-settlements.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
