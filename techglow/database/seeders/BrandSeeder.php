<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class BrandSeeder extends Seeder
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
        $section1->write('Read manufacturers.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();

        $data = json_decode(file_get_contents((__DIR__ . "/data/manufacturers.json")));
        $manufacturers = [];
        foreach ($data as $row) {
            $progressBar->advance();
            $manufacturers[] =
                [
                    "reference" => $row->reference,
                    "id_api" => $row->id,
                    "name" => $row->name,
                    "url_image" => $row->urlImage,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($manufacturers, 500);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbmanufacturer')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
