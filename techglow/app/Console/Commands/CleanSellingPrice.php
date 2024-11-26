<?php

namespace App\Console\Commands;

use App\Models\Product\Supplier;
use App\Models\Product\Product;
use App\Models\Product\SellingPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CleanSellingPrice extends Command
{
    protected $signature = 'clean:selling_price';

    public function handle()
    {
        $suppliers = Supplier::all();
        $suppliersProgressBar = $this->getProgressBar(0, $suppliers->count());
        $suppliersProgressBar->start();
        foreach ($suppliers as $supplier) {
            $suppliersProgressBar->advance();
            $products = Product::withTrashed(true)->get();

            $productsProgressBar = $this->getProgressBar(1, $products->count());
            $productsProgressBar->setProgress(0);
            $productsProgressBar->start();
            foreach ($products as $product) {
                $productsProgressBar->advance();
                $prices = SellingPrice::where("supplier_id", "=", $supplier->id)
                    ->where("product_id", "=", $product->id)
                    ->orderBy("created_at", "ASC")
                    ->get();
                $this->cleaner($prices);
            }
            $productsProgressBar->finish();
        }
        $suppliersProgressBar->finish();
    }

    public function cleaner($prices)
    {
        $current_price = 0;
        $destroy = [];
        foreach ($prices as $price)
        {
            if($current_price == $price->price)
            {
                $destroy[] = $price->id;
            }else{
                $current_price = $price->price;
            }
        }
        SellingPrice::destroy($destroy);
    }

    protected $consoleOutput = null;
    protected $sections = [];

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
}
