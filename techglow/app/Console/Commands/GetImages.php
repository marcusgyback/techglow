<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Outl1ne\NovaMediaHub\Jobs\MediaHubOptimizeAndConvertJob;
use Outl1ne\NovaMediaHub\Models\Media;
use Outl1ne\NovaMediaHub\MediaHub;
use App\Models\Product\Product;
use App\Models\Pricefile\BBImage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

set_time_limit(0);

class GetImages extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize and Convert All media hub images';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->write(0, "Populate Images", true);
        $products = Product::whereNull("image")->get();
        $progressBar = $this->getProgressBar(1, $products->count());
        $progressBar->start();
        $progressBarImages = $this->getProgressBar(3);
        $progressBarImages->start();

        foreach ($products as $product)
        {
            $progressBar->advance();

            $images = BBImage::where("id_api", "=", $product->bb_id)->get();
            $progressBarImages->setProgress(0);
            $progressBarImages->setMaxSteps($images->count());
            $id = [];
            foreach ($images as $image)
            {
                try {
                    $fileobj = MediaHub::storeMediaFromUrl($image->url, "product");
                    $id[] = $fileobj->id;
                }catch (\Exception $e){
                    var_dump($e->getMessage());
                }
                    $progressBarImages->advance();
            }
            if(count($id)) {
                $product->image = $id;
                $product->save();
            }
        }
        $progressBarImages->finish();
        $progressBar->finish();


        $media = Media::all();
        foreach ($media as $m) {
            MediaHubOptimizeAndConvertJob::dispatch($m);
        }
    }
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

}

