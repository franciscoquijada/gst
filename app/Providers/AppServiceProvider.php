<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Laravel\Passport\Passport;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Passport::routes();
        
        \Validator::extend('rut', function( $attr, $value, $params, $validator )
            {
                $rut = preg_replace( '/[^0-9|k|K]/', '', $value );
                return _check_rut($rut);

            }, 'Numero de RUT Invalido.');
    }
}
