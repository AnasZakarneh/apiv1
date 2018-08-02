<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //register a new service
         $this->app->bind('App\libs\Currency\CurrencyInterface', 'App\libs\Currency\FFC');
    }
}
