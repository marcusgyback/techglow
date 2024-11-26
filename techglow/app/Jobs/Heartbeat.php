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

class Heartbeat implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue;
    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 55;
    public function uniqueId(): string
    {
        return $this->queue;
    }

    /**
     * Create a new job instance.
     */
    public function __construct($queue = "")
    {
        $this->queue = $queue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "";
        switch ($this->queue)
        {
            case "high":
                $url = "https://glitch.port30.net/api/0/organizations/techglow-solutions-ab/heartbeat_check/0bc37317-5fca-439a-aca5-0ea3699ad891/";
                break;
            case "email":
                $url = "https://glitch.port30.net/api/0/organizations/techglow-solutions-ab/heartbeat_check/0cdaac50-15d7-461e-a24a-69f4bf260326/";
                break;
            case "order":
                $url = "https://glitch.port30.net/api/0/organizations/techglow-solutions-ab/heartbeat_check/16452083-6884-4532-b173-21ff5f1837a9/";
                break;
            case "default":
            default:
                $url = "https://glitch.port30.net/api/0/organizations/techglow-solutions-ab/heartbeat_check/ebdb16c0-f76b-4ad9-a2dc-5c1796d63921/";
                break;
        }

        if($url !== "") {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST"
            ));
            curl_exec($curl);
            curl_close($curl);
        }

    }
}
