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
        \Blade::include('components.form.select',   'select');
        \Blade::include('components.form.input',    'input');
        \Blade::include('components.form.checkbox', 'checkbox');
        \Blade::include('components.datatable',     'datatable');
        \Blade::include('components.buttons.link',  'link');
        \Blade::include('components.buttons.modal', 'linkModal');
        \Blade::include('components.buttons.action','button');
        \Blade::component('components.card',        'card');
    }
}
