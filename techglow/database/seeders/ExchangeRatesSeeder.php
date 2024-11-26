<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ExchangeRatesSeeder extends Seeder
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
        $section1->write('Read exchange_rates.csv', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $handle = fopen(__DIR__ . "/data/exchange_rates.csv", "r");
        if ($handle === false) {
            new \Exception("File missing!!");
        }
        $insert = [];
        $head = true;
        $headers = [];
        while (($row = fgetcsv($handle, null, ",",'"')) !== FALSE) {
            $progressBar->advance();
            if($head)
            {
                $head=false;
            }else{
                if($row[16] !== "N/A") {
                    $date = $row[0];
                    $sek = (0.0 + $row[16]);
                    $eur = round((1.0 / $sek),4);
                    $insert[] = [
                        'currency_from' => "EUR",
                        'currency_to' => "SEK",
                        'currency_date' => $date,
                        'rate' => $sek,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                        ];
                    $insert[] = [
                        'currency_from' => "SEK",
                        'currency_to' => "EUR",
                        'currency_date' => $date,
                        'rate' => $eur,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ];
                }
            }
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($insert, 1000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('exchange_rates')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
