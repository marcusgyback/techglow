<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pricefile\BBCombinations;
use Outl1ne\NovaMediaHub\Jobs\MediaHubOptimizeAndConvertJob;
use Outl1ne\NovaMediaHub\Models\Media;

class OptimizeAndConvert extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:oac';

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
        $media = Media::all();
        foreach ($media as $m) {
            MediaHubOptimizeAndConvertJob::dispatch($m);
        }
    }
}

