<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateBigBuyProducts;
use App\Jobs\UpdateBigBuyPrices;
use App\Jobs\UpdateExchangeRates;


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
        $schedule->command('cron:update-exchange-rates')
            ->cron('0 */6 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-products')
            ->cron('10 0 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-informations')
            ->cron('20 0 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-manufacturers')
            ->cron('30 0 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-shippings')
            ->cron('40 0 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-images')
            ->cron('50 0 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('cron:bb-import-stocks')
            ->cron('55 */3 * * *')
            ->emailOutputOnFailure('info@techglow.se');


        $schedule->command('cron:update-big-buy-purchase-price')
            ->cron('10 2 * * *')
            ->emailOutputOnFailure('info@techglow.se');

        $schedule->command('heartbeats')
            ->cron('* * * * *')
            ->emailOutputOnFailure('info@techglow.se');
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
