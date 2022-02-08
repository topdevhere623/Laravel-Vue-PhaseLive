<?php

namespace App\Console;

use App\Jobs\UpdateChartScores;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Jobs\RenewSubscriptionsToday;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // TODO - Change from every minute to daily for production
//        $schedule->job(new RenewSubscriptionsToday())->everyMinute()->onOneServer();
        $schedule->job(new UpdateChartScores())->twiceDaily(6, 18);
//        $schedule->job(new UpdateChartScores(), 'charts')->everyFiveMinutes();

        $schedule->command('telescope:prune')->daily();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
