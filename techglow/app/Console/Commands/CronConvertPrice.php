<?php

namespace App\Console\Commands;

use App\Jobs\SetSellingPriceJob;
use App\Mail\DepublishedProduct;
use App\Models\Product\Product;
use Illuminate\Console\Command;
use App\Jobs\SetBigBuyPurchasePriceJob;
use Illuminate\Support\Facades\Mail;
use Log;

class CronConvertPrice extends Command
{
    protected string|null $timestamp = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:convert-price';

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

        $products = Product::all();
        foreach ($products as $product) {
            $product->selling_price =$product->getSellingPrice();
            $product->save();
        }
    }
}
