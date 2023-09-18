<?php

namespace App\Console;

use App\Console\Commands\GetMyIp;
use App\Console\Commands\RabbitPublishBook;
use App\Console\Commands\RabbitPublishWord;
use App\Console\Commands\RefreshProxy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //$schedule->command(RefreshProxy::class)->everyThirtyMinutes();
        //$schedule->command(RabbitPublishBook::class);
        //$schedule->command(RabbitPublishWord::class);

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
