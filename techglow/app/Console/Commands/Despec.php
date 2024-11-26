<?php

namespace App\Console\Commands;

use App\Jobs\PriceChecker;
use Illuminate\Console\Command;
use App\Models\Pricefile\Files;
use App\Models\Pricefile\Despec as DespecModel;
use App\Models\Product\Supplier;

use SebastianBergmann\Type\FalseType;

class Despec extends Command
{
    protected string $slug = "despec";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:despec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importera despec prisdata';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $path = env("DESPEC_BASE_PATH", null);
        if( (!is_null($path)) && (is_dir($path)) ) {
            $supplier = $this->getSupplier();
            $files = scandir($path, SCANDIR_SORT_DESCENDING);
            foreach ($files as $file)
            {
                if(substr($file,0,1) != ".")
                {
                    $file_time =
                        substr($file,0,4) . "-" .
                        substr($file,4,2) . "-" .
                        substr($file,6,2) . " " .
                        substr($file,8,2) . ":" .
                        substr($file,10,2) . ":" .
                        substr($file,12,2);

                    $hash_sha1 = sha1_file(($path . $file));
                    $hash_md5 = md5_file(($path . $file));
                    $dbFile = Files::firstOrCreate([
                        "supplier_id" => $supplier->id,
                        "hash_sha1" => $hash_sha1,
                        "hash_md5" => $hash_md5
                    ],
                    [
                        "supplier_id" => $supplier->id,
                        "name" => $file,
                        "size" => filesize($path . $file),
                        "api" => false,
                        "start_at" => date("Y-m-d H:i:s"),
                        "file_timestamp" => $file_time,
                        "hash_sha1" => $hash_sha1,
                        "hash_md5" => $hash_md5
                    ]);
                    if($dbFile->wasRecentlyCreated)
                    {
                        $this->readFileAndPersist($dbFile);
                        $dbFile->done_at = date("Y-m-d H:i:s");
                        $dbFile->save();
                        PriceChecker::dispatch($dbFile);
                    }
                }
            }
        }else{
            echo "DESPEC_BASE_PATH not set";
        }
    }

    protected function readFileAndPersist($file)
    {
        $handle = fopen((env("DESPEC_BASE_PATH", null) . $file->name), "r");
        if ($handle === false) { return false; }
        $row = 0;
        $head = [];
        while (($data = fgetcsv($handle, null, ";",'"')) !== FALSE) {
            if($row == 0)
            {
                $row++;
                foreach ($data as $key => $value) {
                    $v = $this->camelCaseToSnakeCase($value);
                    $head[$v] = $key;
                }
            }else {
                $row = [
                    "file_id" => $file->id
                ];
                foreach ($head as $name => $index)
                {
                    $row[$name] = $data[$index];
                }
                DespecModel::create($row);
            }
        }
    }

    private function camelCaseToSnakeCase($string)
    {
        switch ($string)
        {
            case "BIDID":
                return "bid_id";
                break;
            case "ItemOEM":
                return "item_oem";
                break;
            case "ItemEAN":
                return "item_ean";
                break;
            case "ItemTxt":
                return "item_txt";
                break;
            case "ItemWebDescription":
                return "item_web_desc";
                break;

            default:
                return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
        }
    }
    protected function getSupplier()
    {
        return Supplier::firstOrCreate(
            [
                "slug" => $this->slug
            ],
            [
                "slug" => $this->slug,
                "active" => true,
                "name" => "Despec Sweden AB",
                "api" => false,
                "flow_class" => "Despec::class",
            ]
        );
    }
}

