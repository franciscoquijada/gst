<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        \Blade::include('components.select',        'select');
        \Blade::include('components.input',         'input');
        \Blade::include('components.checkbox',      'checkbox');
        \Blade::include('components.datatable',     'datatable');
        \Blade::include('components.buttons.link',  'link');
        \Blade::include('components.buttons.modal', 'linkModal');
        \Blade::include('components.buttons.action','buttonAction');
    }
}
