<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ImagesSeeder extends Seeder
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
        $section1->write('Read images.json', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();
        $data = json_decode(file_get_contents((__DIR__ . "/data/images.json")));
        $images = [];
        foreach ($data as $row) {
            foreach ($row->images as $image) {
                $progressBar->advance();
                $images[] =
                    [
                        "id_api" => $row->id,
                        "image_id" => $image->id,
                        "url" => $image->url,
                        "cover" => $image->isCover,
                        "logo" => $image->logo,
                        "whiteBackground" => $image->whiteBackground,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ];
            }
        }
        $chunks = array_chunk($images, 1000);
        $progressBar->finish();
        $section1->write(' Finished', true);
        $section2->write('SQL', true);
        $progressBar = new ProgressBar($section2, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('bbimages')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section2->write(' Finished', true);
    }
}


