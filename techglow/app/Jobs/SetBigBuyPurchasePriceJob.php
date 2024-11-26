<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Pricefile\BBProduct;
use App\Models\Pricefile\BBStock;
use Log;

class SetBigBuyPurchasePriceJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;
    public $uniqueFor = 5;
    public $timeout = 240;
    protected String|Null $timestamp = null;

    public function uniqueId(): string
    {
        return "SetBigBuyPurchasePriceJob" . $this->productId;
    }

    public function __construct(int $id)
    {
        Log::info('SetBigBuyPurchasePriceJob __construct: ' . $id);
        $this->productId = $id;
    }

    public function handle(): void
    {
        Log::info('SetBigBuyPurchasePriceJob handle: ' . $this->productId);
        $this->timestamp = date("Y-m-d H:i:s");
        $products = Product::where("id", "=", $this->productId)->get();
        foreach ($products as $product)
        {
            $this->product($product);
        }
    }

    protected function product(Product $product)
    {
        $bb_product = BBProduct::where("sku", "=", $product->bb_sku)
                                ->where("condition", "=", "NEW")
                                ->get();

        if(count($bb_product) == 0)
        {
            return $this->depublish($product);
        }
        elseif(count($bb_product) == 1)
        {
            $row = $bb_product->first();
            DB::table("purchase_price")->insert(
                [
                    "product_id" => $product->id,
                    "supplier_id" => 1,
                    "article_number" => $row->sku,
                    "price" =>  @$row->wholesalePrice,
                    "price_retail" => @$row->retailPrice,
                    "price_in_shops" => @$row->inShopsPrice,
                    "currency" => "EUR",
                    "stock" => $this->getStock($row->sku),
                    "valid_from" => @$this->timestamp,
                    "intrastat" =>  @$row->intrastat,
                    "created_at" => $this->timestamp,
                    "updated_at" => $this->timestamp,
                ]
            );
            SetSellingPriceJob::dispatch($product->id);
        }
        else
        {
            $this->fail();
        }
    }

    protected function depublish(Product $product)
    {
        // TODO: Kontrollera att produkten bara finns i denna inköpskanal.
        //$product->published = 0;
        //$product->save();
        EmailDepublishedProductJob::dispatch($product->id)->onQueue('email');
        return "";
    }

    protected function getStock($sku)
    {
        $stock_sum = 0;
        $stocks = BBStock::where("sku", "=", $sku)
                           ->get();
        foreach ($stocks as $stock)
        {
            $stock_sum += $stock->stock_quantity;
        }
        return $stock_sum;
    }
}

