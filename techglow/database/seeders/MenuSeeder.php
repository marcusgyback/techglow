<?php

namespace Database\Seeders;

use App\Models\Pricefile\BBCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MenuSeeder extends Seeder
{
    protected function isNullOrBlank($obj)
    {
        if ((is_null($obj)) || ("" === $obj)) {
            return true;
        }
        return false;
    }

    protected $taxonomys = [];
    protected function getBbCategoryChildren($parent, $row_id)
    {
        $db = BBCategory::where("parent_id", "=", $parent)->get();
        foreach ($db as $row) {
            $this->taxonomys[] = [
                "menu_id" => $row_id,
                "category_id" => $row->id_api,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            $this->getBbCategoryChildren($row->id_api, $row_id);
        }
    }


    protected function taxonomy($taxonomy, $row_id)
    {
        if($this->isNullOrBlank($taxonomy))
        {
            return;
        }
        $taxonomy = explode(",", $taxonomy);
        if((!count($taxonomy)) || ($taxonomy[0] == "")) {
            return;
        }
        foreach ($taxonomy as $item) {
            $this->taxonomys[] = [
                "menu_id" => $row_id,
                "category_id" => $item,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            $this->getBbCategoryChildren($item, $row_id);
        }
    }

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
        $section4 = $output->section();
        $section1->write('Read menu.csv', true);
        $progressBar = new ProgressBar($section1);
        $progressBar->start();

        $handle = fopen(__DIR__ . "/data/menu.csv", "r");
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
            $slug = $name = $parent_slug = $weight = $published = $description = null;
            $menu_item = [
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            $slug = @$row[$heads["slug"]];
            $name = @$row[$heads["name"]];
            $parent_slug = @$row[$heads["parent_slug"]];
            $weight = @$row[$heads["weight"]];
            $published = @$row[$heads["published"]];
            $description = @$row[$heads["description"]];
            $taxonomy = @$row[$heads["taxonomy"]];

            if (!$this->isNullOrBlank($slug)) {
                $menu_item["slug"] = $slug;
                $items_lookup[$slug] = $row_id;
            } else {
                throw new Exception("Slug error on row " . $row_id);
            }
            if (!$this->isNullOrBlank($name)) {
                $menu_item["title"] = $name;
            } else {
                throw new Exception("Name error on row " . $row_id);
            }
            if (!$this->isNullOrBlank($parent_slug)) {
                $menu_item["parent_id"] = $parent_slug;
            }
            if (!$this->isNullOrBlank($weight)) {
                $menu_item["weight"] = $weight;
            } else {
                $menu_item["weight"] = 0;
            }
            if ((!$this->isNullOrBlank($published)) && ($published == 1)) {
                $menu_item["published"] = date("Y-m-d H:i:s");
            }
            if (!$this->isNullOrBlank($description)) {
                $menu_item["description"] = $description;
            }
            $this->taxonomy($taxonomy,$row_id);
            $menu_item["id"] = $row_id;
            $items[$row_id] = $menu_item;
        }
        $progressBar->finish();
        $section1->write(' Finished', true);

        $section2->write('Resolve menu', true);
        $progressBar = new ProgressBar($section2);
        $progressBar->setFormat('very_verbose');
        $progressBar->setMaxSteps(count($items));
        $progressBar->start();
        $menu = [];
        foreach ($items as $index => $item) {
            $progressBar->advance();
            if(array_key_exists("parent_id", $item))
            {
                $parent = $items_lookup[$item["parent_id"]];
                $item["parent_id"] = $parent;
                $menu[$parent . $index] = $item;
            }else{
                $menu[$index] = $item;
            }
        }
        ksort($menu);

        $progressBar->finish();
        $section2->write(' Finished', true);

        $chunks = array_chunk($menu, 1); // Important
        $section3->write('SQL', true);
        $progressBar = new ProgressBar($section3, (count($chunks)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('menu')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section3->write(' Finished', true);


        $chunks = array_chunk($this->taxonomys, 500); // Important
        $section4->write('SQL taxonomys', true);
        $progressBar = new ProgressBar($section4, (count($this->taxonomys)));
        $progressBar->start();
        foreach ($chunks as $chunk) {
            DB::table('category_to_menu')->insert($chunk);
            $progressBar->advance();
        }
        $progressBar->finish();
        $section4->write(' Finished', true);




    }
}
