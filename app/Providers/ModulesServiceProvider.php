<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Module;

class ModulesServiceProvider extends ServiceProvider
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
        View::share('modules', Module::all());
    }
}
