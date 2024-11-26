<?php

namespace App\Console\Commands;

use App\Models\Product\ExchangeRates;
use Illuminate\Console\Command;
use Log;

class CronUpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:update-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('CronUpdateExchangeRates Start');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=SEK&from=EUR&amount=1",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . env("APILAYER_KEY")
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);

        $erSEK = ExchangeRates::where('currency_from', 'SEK')
            ->where('currency_to', 'EUR')
            ->where('currency_date', $data->date)->get()->first();

        $erEUR = ExchangeRates::where('currency_from', 'EUR')
            ->where('currency_to', 'SEK')
            ->where('currency_date', $data->date)->get()->first();


        $sek = $data->result;
        $eur = round((1.0 / $sek),6);
        ExchangeRates::create([
            'currency_from' => "EUR",
            'currency_to' => "SEK",
            'currency_date' => $data->date,
            'rate' => $sek,
        ]);
        ExchangeRates::create([
            'currency_from' => "SEK",
            'currency_to' => "EUR",
            'currency_date' => $data->date,
            'rate' => $eur,
        ]);


        if(!is_null($erSEK)) {
            $erSEK->delete();
        }
        if(!is_null($erEUR)) {
            $erEUR->delete();
        }
        Log::info('CronUpdateExchangeRates SEK2EUR:' . $sek);
        Log::info('CronUpdateExchangeRates EUR2SEK:' . $eur);
        Log::info('CronUpdateExchangeRates END');
    }
}
