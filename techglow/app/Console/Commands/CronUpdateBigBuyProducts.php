<?php

namespace App\Console\Commands;

use App\Jobs\SetSellingPriceJob;
use App\Models\Product\Product;
use Illuminate\Console\Command;
use App\Jobs\SetBigBuyPurchasePriceJob;
use Log;

class CronUpdateBigBuyProducts extends Command
{
    protected string|null $timestamp = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:update-big-buy-purchase-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update BigBuy purchase price';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $products = Product::where("published", "=", 1)
                            ->whereNotNull("bb_id")
                            ->pluck('id')
                            ->all();
        foreach ($products as $id) {
            SetBigBuyPurchasePriceJob::dispatch($id);
        }
    }
}
