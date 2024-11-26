<?php

namespace App\Jobs;

use App\Models\Product\ExchangeRates;
use App\Models\Product\Product;
use App\Models\Product\PurchasePrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\KemTaxCalculation;
use App\Helpers\PriceCalculation;
use Illuminate\Support\Facades\DB;
use \Log;


class SetSellingPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product_id;
    public $uniqueFor = 5;
    public $timeout = 240;
    protected String|Null $timestamp = null;
    protected Float|Null $exchange_rate = null;

    public function uniqueId(): string
    {
        return "SetSellingPriceJob" . $this->product_id;
    }

    public function __construct(int $id)
    {
        Log::info('SetSellingPriceJob __construct: ' . $id);
        $this->product_id = $id;
    }

    public function handle(): void
    {
        Log::info('SetSellingPriceJob handle: ' . $this->product_id);
        $this->timestamp = date("Y-m-d H:i:s");
        $this->exchange_rate = $this->getExchangeRate("EUR","SEK");
        $products = Product::where("id", "=", $this->product_id)->get();
        foreach ($products as $product)
        {
            $this->product($product);
        }
    }

    protected function product(Product $product)
    {
        $selling_price = $product->getSellingPriceRow();
        $kem_tax = KemTaxCalculation::Calculate($product->kem_tax, $product->weight);
        if($product->kem_tax_amount !== $kem_tax)
        {
            $product->kem_tax_amount = $kem_tax;
        }
        $purchase = PurchasePrice::where("product_id", "=", $product->id)
            ->whereNull("valid_to")
            ->orderBy('valid_from', 'desc')
            ->first();
        $price = PriceCalculation::Calculate($product, $purchase, $this->exchange_rate, $kem_tax);
        $max_diff_price = ($selling_price->price * 1.05);
        $min_diff_price = $selling_price->price - ($selling_price->price * 0.05);
        if( ($min_diff_price > $price) || ($max_diff_price < $price))
        {
            $product->cache_price_price = $price;
            DB::table('selling_price')->insert([
                "product_id" => $purchase->product_id,
                "supplier_id" => $purchase->supplier_id,
                "price" => $price,
                "currency" => "SEK",
                "valid_from" => $this->timestamp,
                'created_at' => $this->timestamp,
                'updated_at' => $this->timestamp,
            ]);
        }else {
            $product->cache_price_price = $selling_price->price;
        }
        $product->save();
        $purchase_price_ink_moms = PriceCalculation::CalculatePurchasePriceInkMoms($purchase, $this->exchange_rate, $kem_tax);
        if($purchase_price_ink_moms > $price)
        {
            EmailProductPriceWarningJob::dispatch($product->id);
        }
    }

    protected function getExchangeRate($currency_from, $currency_to)
    {
        $rate = ExchangeRates::where("currency_from","=",$currency_from)
            ->where("currency_to","=",$currency_to)
            ->orderBy("currency_date")->get()->first();
        if(!is_null($rate))
        {
            return 0.0 + $rate->rate;
        }
        return $rate;
    }
}

