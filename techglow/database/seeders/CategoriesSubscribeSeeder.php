<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CategoriesSubscribeSeeder extends Seeder
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
        $section3 = $output->section();
        $section1->write('Read categoriessubscribe.csv', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();

        $handle = fopen(__DIR__ . "/data/categoriessubscribe.csv", "r");
        if ($handle === false) {
            new \Exception("File missing!!");
        }
        $row_id = -1;
        $heads = $items_lookup = $items = [];
        while (($row = fgetcsv($handle, null, ";", '"')) !== FALSE) {
            $progressBar->advance();
            $row_id++;
            if (!$row_id) {
                $heads = array_flip($row);
                continue;
            }

            $items[] = [
                "categorie" => $row[$heads["categorie"]],
                "follow" => $row[$heads["follow"]],
                "block" => $row[$heads["block"]],
                "recursive" => $row[$heads["recursive"]],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
        }
        $progressBar->finish();
        $section1->write(' Finished', true);

        $chunks = array_chunk($items, 1);
        $section3->write('SQL', true);
        $progressBar = new ProgressBar($section3, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbcategories_subscribe')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $output->write(' Finished', true);
    }
}
