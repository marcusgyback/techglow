<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;
use App\Models\Pricefile\Files;
use App\Models\Product\Supplier;
use App\Models\Pricefile\BBCategory;
use App\Models\Pricefile\BBCombinations;
use App\Models\Pricefile\BBManufacturer;
use App\Models\Pricefile\Bigbuy as Products;
use App\Jobs\PriceChecker;
use Illuminate\Support\Facades\DB;

class BigBuyApiImportImages extends Command
{
    protected array $product_unique_filter = [];
    protected String|Null $apiUrl = null;
    protected String|Null $apiKey = null;
    protected String|Null $timestamp = null;
    protected Supplier $supplier;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:bb-import-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BigBuy Import Api Data';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info($this->signature . ' Start');
        $this->timestamp = date("Y-m-d H:i:s");
        $this->apiUrl = env("BIGBUY_BASE_API", "https://api.sandbox.bigbuy.eu");
        $this->apiKey = env("BIGBUY_KEY", "NDMwMThlOTM1MWFkNDg4ODlhMWQxNWIxNTJhM2IwNDQzZjVhYzZhYWUxNjdjODEzZDk4YmZkMDQ3NTNlZDdmZA");

        //$this->importProducts();
        //$this->importInformations();
        //$this->importManufacturers();
        //$this->importShippings();
        $this->importImages();
        //$this->importStocks();
        Log::info($this->signature . ' End');
    }

    public function importProducts()
    {
        Log::info('importProducts Start');
        $this->productUniqueFilterReset();
        $products = $this->apiGetReq('/rest/catalog/products');
        $products_inserts = [];
        foreach ($products as $product)
        {
            $commit = true;
            if($this->productUniqueFilter($product->id))
            {
                try {
                    $row = [
                        "id_api" => $product->id,
                        "sku" => $product->sku,
                        "manufacturer" => @$product->manufacturer,
                        "ean13" => @$product->ean13,
                        "weight" => @$product->weight,
                        "height" => @$product->height,
                        "width" => @$product->width,
                        "depth" => @$product->depth,
                        "dateUpd" => @$product->dateUpd,
                        "category" => @$product->category,
                        "dateUpdDescription" => @$product->dateUpdDescription,
                        "dateUpdImages" => @$product->dateUpdImages,
                        "dateUpdStock" => @$product->dateUpdStock,
                        "wholesalePrice" => @$product->wholesalePrice,
                        "retailPrice" => @$product->retailPrice,
                        "dateAdd" => @$product->dateAdd,
                        "video" => @$product->video,
                        "active" => @$product->active,
                        "attributes" => @$product->attributes,
                        "categories" => @$product->categories,
                        "images" => @$product->images,
                        "taxRate" => @$product->taxRate,
                        "taxId" => @$product->taxId,
                        "inShopsPrice" => @$product->inShopsPrice,
                        "condition" => @$product->condition,
                        "logisticClass" => @$product->logisticClass,
                        "tags" => @$product->tags,
                        "intrastat" => @$product->intrastat,
                    ];
                } catch (\Exception $e) {
                    $commit = false;
                    echo "\n" . $e->getMessage() . "\n";
                }
                if (($commit) && (count($row))) {
                    $products_inserts[] = $row;
                }
            }

        }
        $this->truncateAndChunkInsert($products_inserts, "bbproducts");
        Log::info('importProducts End');
    }

    public function importInformations()
    {
        Log::info('importInformations Start');
        $this->productUniqueFilterReset();
        $products = $this->apiGetReq('/rest/catalog/productsinformation', ["isoCode" => "sv"]);
        $products_inserts = [];
        foreach ($products as $product)
        {
            $commit = true;
            if($this->productUniqueFilter($product->id))
            {
                try {
                    $row = [
                        "id_api" => $product->id,
                        "sku" => $product->sku,
                        "manufacturer" => @$product->manufacturer,
                        "name" => @$product->name,
                        "description" => @$product->description,
                        "url" => @$product->url,
                        "dateUpdDescription" => @$product->dateUpdDescription,
                        "shortDescription" => @$product->shortDescription,
                        "descriptionRetailer" => @$product->descriptionRetailer,
                        "translation" => @$product->translation,
                        "metaKeywords" => @$product->metaKeywords,
                        "created_at" => $this->timestamp,
                        "updated_at" => $this->timestamp,
                    ];
                } catch (\Exception $e) {
                    $commit = false;
                    echo "\n" . $e->getMessage() . "\n";
                }
                if (($commit) && (count($row))) {
                    $products_inserts[] = $row;
                }
            }

        }
        $this->truncateAndChunkInsert($products_inserts, "bbinformation");
        Log::info('importInformations End');
    }

    public function importManufacturers()
    {
        Log::info('importManufacturers Start');
        $manufacturers = $this->apiGetReq('/rest/catalog/manufacturers');
        $manufacturers_inserts = [];
        foreach ($manufacturers as $manufacturer)
        {
            $commit = true;
            try {
                $row = [
                    "id_api" => $manufacturer->id,
                    "name" => $manufacturer->name,
                    "url_image" => $manufacturer->urlImage,
                    "reference" => $manufacturer->reference,
                    "created_at" => $this->timestamp,
                    "updated_at" => $this->timestamp,
                ];
            } catch (\Exception $e) {
                $commit = false;
                echo "\n" . $e->getMessage() . "\n";
            }
                if (($commit) && (count($row))) {
                    $manufacturers_inserts[] = $row;
            }
        }
        $this->truncateAndChunkInsert($manufacturers_inserts, "bbmanufacturer");
        Log::info('importManufacturers End');
    }

    public function importShippings()
    {
        Log::info('importShippings Start');
        $shippings = $this->apiGetReq('/rest/shipping/lowest-shipping-costs-by-country/sv');
        $shippings_inserts = [];
        foreach ($shippings as $shipping)
        {
            $commit = true;
            try {
                $row = [
                    "reference" => $shipping->reference,
                    "cost" => $shipping->cost,
                    "carrierId" => $shipping->carrierId,
                    "carrierName" => $shipping->carrierName,
                    "created_at" => $this->timestamp,
                    "updated_at" => $this->timestamp,
                ];
            } catch (\Exception $e) {
                $commit = false;
                echo "\n" . $e->getMessage() . "\n";
            }
            if (($commit) && (count($row))) {
                $shippings_inserts[] = $row;
            }
        }
        $this->truncateAndChunkInsert($shippings_inserts, "bbshippings");
        Log::info('importShippings End');
    }

    public function importImages()
    {
        Log::info('importImages Start');
        $images = $this->apiGetReq('/rest/catalog/productsimages');
        $images_inserts = [];
        foreach ($images as $image)
        {
            foreach ($image->images as $image_rows) {
                $commit = true;
                try {
                    $row = [
                        "id_api" => $image->id,
                        "image_id" => $image_rows->id,
                        "url" => $image_rows->url,
                        "cover" => $image_rows->isCover,
                        "logo" => $image_rows->logo,
                        "whiteBackground" => $image_rows->whiteBackground,
                        "created_at" => $this->timestamp,
                        "updated_at" => $this->timestamp,
                    ];
                } catch (\Exception $e) {
                    $commit = false;
                    echo "\n" . $e->getMessage() . "\n";
                }
                if (($commit) && (count($row))) {
                    $images_inserts[] = $row;
                }
            }
        }
        $this->truncateAndChunkInsert($images_inserts, "bbimages");
        Log::info('importImages End');
    }

    public function importStocks()
    {
        Log::info('importStocks Start');
        $stocks = $this->apiGetReq('/rest/catalog/productsstock');
        $stocks_inserts = [];
        foreach ($stocks as $stock)
        {
            $commit = true;
            foreach ($stock->stocks as $stock_rows) {
                try {
                    $row = [
                        "id_api" => $stock->id,
                        "sku" => $stock->sku,
                        "stock_quantity" => $stock_rows->quantity,
                        "stock_min_handling_days" => $stock_rows->minHandlingDays,
                        "stock_max_handling_days" => $stock_rows->maxHandlingDays,
                        "stock_warehouse" => $stock_rows->warehouse,
                        "updated_at" => $this->timestamp,
                        "created_at" => $this->timestamp,
                    ];
                } catch (\Exception $e) {
                    $commit = false;
                    dd($stock);
                    echo "\n" . $e->getMessage() . "\n";
                }
                if (($commit) && (count($row))) {
                    $stocks_inserts[] = $row;
                }
            }
        }
        $this->truncateAndChunkInsert($stocks_inserts, "bbstocks");
        Log::info('importStocks End');
    }

    protected function truncateAndChunkInsert($rows, $table)
    {
        Log::info('truncateAndChunkInsert: ' . $table . ' Rows:' . count($rows));
        $chunks = array_chunk($rows, 2000);
        DB::table($table)->truncate();
        foreach ($chunks as $chunk) {
            //sleep(1);
            DB::table($table)->insert($chunk);
        }
    }

    protected function productUniqueFilterReset()
    {
        $this->product_unique_filter = [];
    }

    protected function productUniqueFilter($id)
    {
        if (!array_key_exists($id, $this->product_unique_filter)) {
            $this->product_unique_filter[$id] = true;
            return true;
        }
        return false;
    }

    protected function apiGetReq($endpoint, $params = [])
    {
        $url = $this->apiUrl . $endpoint;

        if(count($params))
        {
            $url = $url . '?' . http_build_query($params);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->apiKey,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}

