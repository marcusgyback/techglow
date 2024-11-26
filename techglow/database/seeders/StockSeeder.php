<?php

namespace Database\Seeders;

use App\Models\Pricefile\BBStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();
        $section1 = $output->section();
        $section2 = $output->section();
        $data = json_decode(file_get_contents((__DIR__ . "/data/stock.json")));
        $stock_rows = [];
        $section1->write('Read stock.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        foreach ($data as $row) {
            foreach ($row->stocks as $stock) {
                $progressBar->advance();
                $stock_rows[] =
                [
                    "id_api" => $row->id,
                    "sku" => $row->sku,
                    "stock_quantity" => $stock->quantity,
                    "stock_min_handling_days" => $stock->minHandlingDays,
                    "stock_max_handling_days" => $stock->maxHandlingDays,
                    "stock_warehouse" => $stock->warehouse,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
            }
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($stock_rows, 1000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbstocks')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
