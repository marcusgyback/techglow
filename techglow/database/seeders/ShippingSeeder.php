<?php

namespace Database\Seeders;

use App\Models\Pricefile\BBShipping;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ShippingSeeder extends Seeder
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
        $section1->write('Read shipping.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $data = json_decode(file_get_contents((__DIR__ . "/data/shipping.json")));
        $shippings = [];
        foreach ($data as $row) {
            $progressBar->advance();
            $commit = true;
            try {
                $row =
                    [
                        "reference" => $row->reference,
                        "cost" => $row->cost,
                        "carrierId" => $row->carrierId,
                        "carrierName" => $row->carrierName,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ];

            } catch (\Exception $e) {
                $commit = false;
            }
            if($commit)
            {
                $shippings[] = $row;
            }
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($shippings, 1000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbshippings')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
