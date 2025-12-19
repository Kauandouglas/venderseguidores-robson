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
        $schedule->command('queue:work --max-time=55 --tries=3')->withoutOverlapping()->runInBackground();
        $schedule->command('update:apiProvider')->withoutOverlapping()->runInBackground()->everyTenMinutes();
        $schedule->command('refill:auto')->withoutOverlapping()->runInBackground();
        $schedule->command('verify:order')->withoutOverlapping()->runInBackground();
        $schedule->command('verify:priceCostService')->withoutOverlapping()->runInBackground();
        $schedule->command('verifyPriceNow:service')->withoutOverlapping()->runInBackground();
        $schedule->command('cancel:payment')->withoutOverlapping()->runInBackground();
        $schedule->command('generate:invoice')->withoutOverlapping()->runInBackground();
        $schedule->command('sendMessagee:notConfiguredStore')->withoutOverlapping()->runInBackground();
        $schedule->command('send:userNotify')->withoutOverlapping()->runInBackground();
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
