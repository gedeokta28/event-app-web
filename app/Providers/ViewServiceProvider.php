<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

   /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('superadmin', function ($value) {
            if ($value instanceof User) {
                return $value->isSuperAdmin();
            }

            return false;
        });
    }
}
