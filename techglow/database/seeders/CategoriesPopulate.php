<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pricefile\BBCategoriesSubscribe;
use App\Models\Pricefile\BBCategory;
use App\Models\Pricefile\BBProduct;
use App\Models\Pricefile\BBInformation;
use App\Models\Pricefile\BBProductsTaxonomies;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CategoriesPopulate extends Seeder
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
        $this->write(0, "Setup BB categories by subscriptions", true);
        $progressBar = $this->getProgressBar(0);
        $progressBar->start();
        $cs = BBCategoriesSubscribe::all();
        foreach ($cs as $item) {
            $progressBar->advance();
            if ($item->follow) {
                $this->subscriptions_follow[$item->categorie] = $item->categorie;
            }

            if ($item->block) {
                $this->subscriptions_block[$item->categorie] = $item->categorie;
            }

            if ($item->recursive) {
                $this->subscriptions_recursive[$item->categorie] = $item->categorie;
            }
        }
        $categorys = [];
        foreach ($this->subscriptions_recursive as $item) {
            $progressBar->advance();
            $this->getBbCategoryChildren($item, $categorys, $progressBar);
        }

        foreach ($this->subscriptions_follow as $item) {
            $progressBar->advance();
            $res = BBCategory::where("id_api", "=", $item)->get()->first()?->id_api;
            if (!is_null($res)) {
                $categorys[$res] = $res;
            }
        }
        foreach ($this->subscriptions_block as $item) {
            $progressBar->advance();
            $res = BBCategory::where("id_api", "=", $item)->get()->first()?->id_api;
            if ((!is_null($res)) && (array_key_exists($res, $categorys))) {
                unset($categorys[$res]);
            }
        }
        $progressBar->finish();
        $this->write(0, " Finished", true);

        $this->write(1, "Resolve categories", true);
        ksort($categorys);
        $res = BBCategory::whereIn("id_api", $categorys)->get();
        $progressBar = $this->getProgressBar(1, count($res));
        $progressBar->start();
        $category = [];
        foreach ($res as $item)
        {
            $progressBar->advance();
            $category[$item->id_api] = [
                "id" => $item->id_api,
                "slug" => $item->urls,
	            "name" => $item->name,
            ];
        }
        ksort($category,SORT_NUMERIC);
        $progressBar->finish();

        $this->write(2, "SQL", true);
        $chunks = array_chunk($category, 10);
        $progressBar = $this->getProgressBar(2, count($res));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('categories')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->write(2, " Finished", true);
    }
}
