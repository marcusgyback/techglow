<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pricefile\BBInformation;
use App\Models\Pricefile\BBSkuManufacturer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProductInfoSeeder extends Seeder
{

    protected $sku_manufacturer = [];
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
        $this->sku_manufacturer = BBSkuManufacturer::all()->pluck('brand_id','sku')->all();
        $output = new ConsoleOutput();
        $section1 = $output->section();
        $section2 = $output->section();
        $section1->write('Read information.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $data = json_decode(file_get_contents((__DIR__ . "/data/information.json")));
        $info = [];
        foreach ($data as $row) {
            $progressBar->advance();
            try {
                if($this->productUniqueFilter($row->id)) {
                    $info[] =
                        [
                            "id_api" => @$row->id,
                            "sku" => @$row->sku,
                            "name" => @$row->name,
                            "description" => @$row->description,
                            "url" => @$row->url,
                            "dateUpdDescription" => @$row->dateUpdDescription,
                            "shortDescription" => @$row->shortDescription,
                            "descriptionRetailer" => @$row->descriptionRetailer,
                            "translation" => @$row->translation,
                            "metaKeywords" => @$row->metaKeywords,
                            "manufacturer" => $this->skuToManufacturer(@$row->manufacturer,@$row->sku),
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ];
                }
            }catch (\Exception $e) {
                echo "\n" . $e->getMessage() . "\n";
            }

        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($info, 2000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbinformation')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }

    protected function skuToManufacturer($manufacturer, $sku)
    {
        if(!is_null($manufacturer)){
            return $manufacturer;
        }

        if(array_key_exists($sku, $this->sku_manufacturer)){
            return $this->sku_manufacturer[$sku];
        }

        return null;
    }
}


