<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSearchIndex implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function __construct()
    {
        Log::info('UpdateSearchIndex call');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('UpdateSearchIndex handle');
    }
}
