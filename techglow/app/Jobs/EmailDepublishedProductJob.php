<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepublishedProduct;
use Log;

class EmailDepublishedProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;

    public function uniqueId(): string
    {
        return "EmailDepublishedProductJob" . $this->productId;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(int $id)
    {
        Log::info('EmailDepublishedProductJob __construct: ' . $id);
        $this->productId = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('EmailDepublishedProductJob handle: ' . $this->productId);
        $product = Product::find($this->productId);


        Mail::to("info@techglow.se")->send(new DepublishedProduct($product));
    }
}
