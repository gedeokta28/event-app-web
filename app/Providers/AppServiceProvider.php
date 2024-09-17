<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Stock;
use App\Observers\CustomerObserver;
use App\Observers\StockObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Customer::observe(CustomerObserver::class);
        // Stock::observe(StockObserver::class);
    }
}
