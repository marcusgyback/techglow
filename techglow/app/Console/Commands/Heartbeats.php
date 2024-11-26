<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Heartbeat;

class Heartbeats extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heartbeats';

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
        $queues = [
            "high",
            "email",
            "order",
            "default",
        ];
        foreach ($queues as $queue) {
            Heartbeat::dispatch($queue);
        }
    }
}

