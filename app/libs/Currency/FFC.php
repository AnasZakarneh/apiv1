<?php

namespace App\libs\Currency;

use App\libs\Currency\CurrencyInterface;
use App\Currency;
use App\Http\Requests;
use GuzzleHttp\Client;

class FFC implements CurrencyInterface {

	const prefix = 'currency_code';

	public function getRate($code) {

		if (app('cache')->has(self::prefix.$code)) {
			return app('cache')->get(self::prefix.$code);
		}

		 // TODO mmove to liveRate()
		$client = new Client();
        $response = $client->request('GET', 'https://free.currencyconverterapi.com/api/v6/convert?q=USD_' . $code);
        $results = json_decode($response->getBody(),true);
        if(! isset($results['results']) || ! isset($results['results']['USD_' . $code])) {
            return "";
        }

        $rate = $results['results']['USD_' . $code]['val'];

        app('cache')->put(self::prefix.$code, $rate, 60*30);


        return $rate;
	}

}
