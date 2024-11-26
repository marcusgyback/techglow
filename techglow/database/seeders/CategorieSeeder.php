<?php

namespace Database\Seeders;

use App\Models\Pricefile\BBCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CategorieSeeder extends Seeder
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
        $section1->write('Read taxonomies.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $data = json_decode(file_get_contents((__DIR__ . "/data/taxonomies.json")));
        $taxonomies = [];
        foreach ($data as $row) {
            $progressBar->advance();
            $taxonomies[] =
                [
                    "id_api" => $row->id,
                    "parent_id" => $row->parentTaxonomy,
                    "name" => $row->name,
                    "urls" => $row->url,
                    "image_urls" => $row->urlImages,
                    "date_add" => $row->dateAdd,
                    "date_upd" => $row->dateUpd,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
        }
        $progressBar->finish();
        $section1->write(' Finished', true);
        $chunks = array_chunk($taxonomies, 1000);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbcategories')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}
