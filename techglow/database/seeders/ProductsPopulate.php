<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pricefile\BBCategoriesSubscribe;
use App\Models\Pricefile\BBCategory;
use App\Models\Pricefile\BBProduct;
use App\Models\Pricefile\BBInformation;
use App\Models\Pricefile\BBProductsTaxonomies;
use App\Models\Product\CategoryToMenu;
use App\Models\Product\Category;
use App\Models\Product\Menu;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProductsPopulate extends Seeder
{

    protected $consoleOutput = null;
    protected $sections = [];
    protected $our_art_no = 30000000;
    protected $pfilter = [];
    protected $purchase_price = [];

    protected function getSection($id)
    {
        if (!array_key_exists($id, $this->sections)) {
            if (is_null($this->consoleOutput)) {
                $this->consoleOutput = new ConsoleOutput();
            }
            $this->sections[$id] = $this->consoleOutput->section();
        }
        return $this->sections[$id];
    }

    protected $progress_bars = [];

    protected function getProgressBar($id, int $max = 0)
    {
        if (!array_key_exists($id, $this->progress_bars)) {
            $this->progress_bars[$id] = new ProgressBar($this->getSection($id), $max);
        }
        return $this->progress_bars[$id];
    }

    protected function write($section_id, string $messages, bool $newline = false)
    {
        $section = $this->getSection($section_id);
        $section->write($messages, $newline);
    }

    protected function getBbCategoryChildren($parent, &$categorys = [], &$progress_bar)
    {
        $progress_bar->advance();
        $db = BBCategory::where("parent_id", "=", $parent)->get();
        foreach ($db as $row) {
            $categorys[$row->id_api] = $row->id_api;
            $this->getBbCategoryChildren($row->id_api, $categorys, $progress_bar);
        }
        return $categorys;
    }

    protected $subscriptions_follow = [];
    protected $subscriptions_block = [];
    protected $subscriptions_recursive = [];
    protected $subscriptions = [];

    public function run()
    {
        $this->write(0, "Populate products by categories", true);

        $categorys = Category::all()->pluck("id")->toArray();
        $products = BBProductsTaxonomies::whereIn("taxonomy", $categorys)->get()->pluck("product");
        $this->write(0, "Import products", true);
        $this->write(0, "Collect and filter", true);
        $progressBar = $this->getProgressBar(1);
        $progressBar->start();
        $products_array = $products->toArray();
        $products_chunks = array_chunk($products_array, 1000);

        $products_chunks_progress_bar = $this->getProgressBar(2, count($products_chunks));
        $products_chunks_progress_bar->start();

        foreach ($products_chunks as $chunk) {
            $products_chunks_progress_bar->advance();
            $this->setProducts($chunk);
        }
        $products_chunks_progress_bar->finish();
        $this->write(2, " Finished", true);
        $this->setPurchasePrices();
    }

    protected function setProducts($products)
    {
        $skus = BBProduct::whereIn("id_api", $products)->where("condition","=","NEW")->get()->pluck("sku");
        $bar = $this->getProgressBar(3, count($skus));
        $bar->start();
        $bb_products = BBProduct::whereIn("sku", $skus)->get();
        $bb_information = BBInformation::whereIn("sku", $skus)->get();
        $products = $informations = $data = [];
        foreach ($bb_products as $product)
        {
            $bar->advance();
            $products[$product->sku] = $product;
        }
        $bar->setProgress(0);
        foreach ($bb_information as $information)
        {
            $bar->advance();
            $informations[$information->sku] = $information;
        }
        $bar->setProgress(0);
        $data = [];
        foreach ($skus as $sku)
        {
            $bar->advance();
            if(array_key_exists($sku, $products) &&  array_key_exists($sku, $informations) && $this->unProduct($products[$sku]["id_api"]))
            {

                $data[] = $this->createArray($products[$sku], $informations[$sku]);
            }

        }
        DB::table('products')->insert($data);
        $bar->finish();
    }

    protected function unProduct($id)
    {
        if(!array_key_exists($id, $this->pfilter))
        {
            $this->pfilter[$id] = true;
            return true;
        }
        return false;
    }

    protected function getMenu($id_api)
    {
        $taxonomy =  BBProductsTaxonomies::where("product", "=", $id_api)->get()->pluck("taxonomy");
        $menu = CategoryToMenu::whereIn("category_id", $taxonomy)->get()->pluck("menu_id")->first();
        if(is_null($menu))
        {
            return 7;
        }
        return $menu;
    }

    protected function getCategory($id_api)
    {
        $taxonomy =  BBProductsTaxonomies::where("product", "=", $id_api)->get()->pluck("taxonomy");
        $category = Category::whereIn("id", $taxonomy)->get()->pluck("id")->first();
        if(is_null($category))
        {
            return null;
        }
        return $category;
    }

    protected function createArray($product, $information)
    {
        $this->purchase_price[$product["sku"]] = [
        "supplier_id" => 1,
        "article_number" => $product["sku"],
        "price" => $product["wholesalePrice"],
        "price_retail" => $product["retailPrice"],
        "price_in_shops" => $product["inShopsPrice"],
        "currency" => "EUR",
        "valid_from" => date("Y-m-d H:i:s"),
        "intrastat" => $product["intrastat"],
        "created_at" => date("Y-m-d H:i:s"),
        "updated_at" => date("Y-m-d H:i:s"),
        ];
        return [
            /*
            "brand_id"
            /**/
            "category_id" => $this->getCategory($product["id_api"]),
            "menu_id" => $this->getMenu($product["id_api"]),
            "our_art_no" => $this->our_art_no++,
            "brand_id"=> $information["manufacturer"],
            "bb_id"=> $product["id_api"],
            "bb_sku" => $product["sku"],
            "slug" => $information["url"],
            "ean"=> $product["ean13"],
            "name" => $information["name"],
            "description" => $information["description"],
            "width" => $product["width"],
            "height"=> $product["height"],
            "depth" => $product["depth"],
            "weight" => $product["weight"],
            "created_at"=> $product["dateAdd"],
            "updated_at"  => $product["dateUpd"],
            "published" => 1,
            "vat_class_se" => "25_percent",
        ];
    }

    protected function setPurchasePrices()
    {
        $products = Product::whereNotNull("bb_id")->get()->pluck('id','bb_sku')->all();
        $insert = [];
        foreach ($this->purchase_price as $sku => $purchase_price)
        {
            $purchase_price["product_id"] = $products[$sku];
            $insert[] = $purchase_price;
        }

        $this->write(5, "Set purchase prices", true);
        $chunks = array_chunk($insert, 50);
        $progressBar = $this->getProgressBar(5, count($chunks));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('purchase_price')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->write(5, " Finished", true);
    }
}
