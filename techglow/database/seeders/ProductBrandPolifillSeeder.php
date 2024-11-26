<?php

namespace Database\Seeders;

use App\Models\Product\Supplier;
use Illuminate\Database\Seeder;
use App\Models\Pricefile\BBProduct;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Models\Product\CategoryToMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Product;
use App\Models\Product\SellingPrice;
use App\Models\Product\PurchasePrice;
use App\Models\Product\ExchangeRates;
use Nette\Utils\Floats;


class ProductBrandPolifillSeeder extends Seeder
{

    public function run()
    {
        $brand = Brand::all()->pluck('id')->all();
        $output = new ConsoleOutput();
        $section1 = $output->section();
        $section2 = $output->section();
        $section1->write('Read product.csv', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();

        $handle = fopen(__DIR__ . "/data/product.csv", "r");
        if ($handle === false) {
            new \Exception("File missing!!");
        }
        $insert = [];
        $head = true;
        while (($row = fgetcsv($handle, null, ";", '"')) !== FALSE) {
            $progressBar->advance();
            if ($head) {
                $head = false;
            } else {
                if(array_key_exists($row[8],$brand)) {
                    $insert[] =
                        [
                            "sku" => $row[0],
                            "brand_id" => $row[8],
                            "created_at" => date("Y-m-d H:i:s"),
                            "updated_at" => date("Y-m-d H:i:s"),
                        ];
                }
            }
        }
        $progressBar->finish();
        $section1->write(' Finished', true);


        $chunks = array_chunk($insert, 2000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbskumanufacturer')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
