<?php

namespace App\Console;

use App\Models\Coupon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Existing scheduled tasks
        $schedule
            ->call(function () {
                Coupon::whereDate('expiration_date', '<', now())->delete();
            })
            ->daily();

        $schedule->command('subscriptions:check')->daily();
        $schedule->command('feedback:send')->everyTwoMinutes();
     //   $schedule->command('smartclick:process')->everyMinute();

        // Add this new command for queue balancing
        $schedule->command('queues:balance')->everyFiveMinutes();
        $schedule->command('autoretarget:process')->everyMinute(); // Adjust frequency as needed
        $schedule->command('abandoned-cart:send-messages')->everyFiveMinutes();
        // Fetch abandoned carts from both platforms
        // $schedule->command('abandoned-carts:fetch')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        \App\Console\Commands\ProcessAutoRetarget::class;

        require base_path('routes/console.php');
    }
}
