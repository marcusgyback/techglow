<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Product\PurchasePrice;
use App\Models\Product\ExchangeRates;
use App\Models\Product\Product;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class SellingPricePopulate extends Seeder
{

    protected $products = [];
    protected $EURtoSEK = 0;

    public function run()
    {
        $this->EURtoSEK = $this->getExchangeRate("EUR","SEK");
        foreach (Product::all() as $item)
        {
            $this->products[$item->id] =
                [
                    "weight" => $item->weight,
                    "kem_tax" => $item->kem_tax,
                    "margin_target" => $item->margin_target,
                ];
        }
        $output = new ConsoleOutput();
        $section1 = $output->section();
        $section2 = $output->section();
        $section1->write('Calculate selling price', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $purchase_price = PurchasePrice::all();
        foreach ($purchase_price as $row) {
            $progressBar->advance();
            if(array_key_exists($row["product_id"], $this->products)) {
                $manufacturers[] =
                    [
                        "product_id" => $row["product_id"],
                        "supplier_id" => $row["supplier_id"],
                        "price" => $this->calcPrice($row),
                        "currency" => "SEK",
                        "valid_from" => date("Y-m-d H:i:s"),
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ];
            }
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($manufacturers, 500);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('selling_price')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
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

    protected function calcPrice($purchase)
    {
        $kem_tax_rate = 0;
        $kem_tax_roof = 497;
        switch ($this->products[$purchase->product_id]["kem_tax"])
        {
            case "appliances":
                $kem_tax_rate = 12;
                break;
            case "others":
                $kem_tax_rate = 181;
                break;
            default:
                $kem_tax_rate = 0;
                break;
        }
        $kem_tax = $this->products[$purchase->product_id]["weight"] * $kem_tax_rate;
        if($kem_tax > $kem_tax_roof)
        {
            $kem_tax = $kem_tax_roof;
        }
        $margin_target =  1.0 + ($this->products[$purchase->product_id]["margin_target"] / 100);
        $price_sek = ceil($this->EURtoSEK * $purchase->price);
        $price_target = $price_sek * $margin_target;
        $price = $price_target + $kem_tax;
        $price = $price * 1.25;
        $oren = (int) (ceil($price) * 100);
        return $oren;
    }
}
