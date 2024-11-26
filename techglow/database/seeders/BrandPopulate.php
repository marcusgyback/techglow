<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pricefile\BBManufacturer;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class BrandPopulate extends Seeder
{

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

    protected function write($section_id, string $messages, bool $newline = false)
    {
        $section = $this->getSection($section_id);
        $section->write($messages, $newline);
    }

    public function run()
    {
        $this->write(0, "Populate Brands", true);
        $progressBar = $this->getProgressBar(0);
        $progressBar->start();
        $brands = BBManufacturer::all();
        $inserts = [];
        foreach ($brands as $brand)
        {
            $inserts[] = [
                "id" => $brand["reference"],
                "published" => 1,
                "name" => $brand["name"],
                "created_at" => $brand["created_at"],
                "updated_at" => $brand["updated_at"],
            ];
        }
        $progressBar->finish();

        $this->write(1, "SQL", true);
        $chunks = array_chunk($inserts, 10);
        $progressBar = $this->getProgressBar(1, count($chunks));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('brands')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->write(1, " Finished", true);
    }
}
