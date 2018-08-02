<?php
namespace App\libs\Currency;

interface CurrencyInterface {

	public function getRate($code);
	
}

