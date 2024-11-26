<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product\Product;
use Log;

class PriceChecker implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 300;

    public function uniqueId(): string
    {
        return $this->data->id;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        Log::info('PriceChecker call: ' . $product->id);
        $this->data = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('PriceChecker handle: ' . $this->data->id);
        var_dump("handle",$this->data);
    }
}
