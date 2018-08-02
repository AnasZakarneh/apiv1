<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

use App\Currency;

use App\Http\Requests;
use GuzzleHttp\Client;

class CurrenciesSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://free.currencyconverterapi.com/api/v6/currencies');
        $results = json_decode($response->getBody());
        $currencies = Currency::all();

        foreach($results as $row) {
            $isInDB = false;
            foreach($row as $key => $val) {
                foreach ($currencies as $currency) {
                    if ($key == $currency->code) {
                        $isInDB = true;
                    }
                }

                if (!$isInDB) {
                    $symbol = "";
                    if(isset($val->currencySymbol)) {
                        $symbol = $val->currencySymbol;
                    }

                    Currency::create(
                        [
                            'code' => $key,
                            'symbol' => $symbol,
                            'name' => $val->currencyName,
                             

                        ]
                    );
                }
            }
        }

        

        


    }
}
