<?php

namespace Database\Seeders;

use App\Models\Product\Supplier;
use Illuminate\Database\Seeder;
use App\Models\Pricefile\BBProduct;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProductSeeder extends Seeder
{

    protected $product_unique_filter = [];
    protected function productUniqueFilter($id)
    {
        if(!array_key_exists($id, $this->product_unique_filter))
        {
            $this->product_unique_filter[$id] = true;
            return true;
        }
        return false;
    }

    public function run()
    {
        $output = new ConsoleOutput();
        $section1 = $output->section();
        $section2 = $output->section();
        $section1->write('Read products.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $data = json_decode(file_get_contents((__DIR__ . "/data/products.json")));
        $products = [];
        foreach ($data as $row) {
            $progressBar->advance();
            $commit = true;
            try {
                if(($row->condition == "NEW") && ($this->productUniqueFilter($row->id))) {
                    $product =
                        [
                            "id_api" => $row->id,
                            "sku" => $row->sku,
                            "ean13" => @$row->ean13,
                            "weight" => @$row->weight,
                            "height" => @$row->height,
                            "width" => @$row->width,
                            "depth" => @$row->depth,
                            "dateUpd" => @$row->dateUpd,
                            "category" => @$row->category,
                            "dateUpdDescription" => @$row->dateUpdDescription,
                            "dateUpdImages" => @$row->dateUpdImages,
                            "dateUpdStock" => @$row->dateUpdStock,
                            "wholesalePrice" => @$row->wholesalePrice,
                            "retailPrice" => @$row->retailPrice,
                            "dateAdd" => @$row->dateAdd,
                            "video" => @$row->video,
                            "active" => @$row->active,
                            "attributes" => @$row->attributes,
                            "categories" => @$row->categories,
                            "images" => @$row->images,
                            "taxRate" => @$row->taxRate,
                            "taxId" => @$row->taxId,
                            "inShopsPrice" => @$row->inShopsPrice,
                            "condition" => @$row->condition,
                            "logisticClass" => @$row->logisticClass,
                            "tags" => @$row->tags,
                            "intrastat" => @$row->intrastat,
                        ];
                }
            }catch (\Exception $e) {
                $commit = false;
                echo "\n" . $e->getMessage() . "\n";
            }
            if($commit)
            {
                $products[] = $product;
            }
        }

        $progressBar->finish();
        $section1->write(' Finished', true);


        $section2->write('SQL', true);
        $chunks = array_chunk($products, 2000);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbproducts')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
