<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailProductPriceWarningJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;

    public function uniqueId(): string
    {
        return "EmailProductPriceWarningJob" . $this->productId;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(int $id)
    {
        Log::info('EmailProductPriceWarningJob __construct: ' . $id);
        $this->productId = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('EmailProductPriceWarningJob handle: ' . $this->productId);
    }
}
