<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Http\Resources\Currency as CurrencyResource;
use App\libs\Currency\CurrencyInterface;
class CurrencyController extends Controller
{
    protected $currency;
    public function __construct(CurrencyInterface $c) {
        $this->currency = $c;
    }
	/**
	* return all currencies data
	* @return {JSON} : all currencies 
	*/
	public function index() {
    	//pass a currency to the currency resource class in order to transform it.
    	return new CurrencyResource(Currency::paginate(10));
    }

    /**
	 * retur the currency that has special code
	 * @param {string} : code for the currency
	 * @return {JSON} : represent the currency
     */
    public function show($code) {
    	//pass a currency array to the currency resource class in order to transform it.
        return new CurrencyResource(Currency::where('code', $code)->get());
    }

    /**
    *return the rate for an currency according to USD
    *@param {string} : code for the currency
    */
    public function rate($code) {
    
        return $this->currency->getRate($code);
    }
}
