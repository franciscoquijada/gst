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
        \Blade::component('components.form.select',   'select');
        \Blade::component('components.form.input',    'input');
        \Blade::component('components.form.file',     'file');
        \Blade::component('components.form.checkbox', 'checkbox');
        \Blade::component('components.datatable',     'datatable');
        \Blade::component('components.buttons.link',  'link');
        \Blade::component('components.buttons.modal', 'linkModal');
        \Blade::component('components.buttons.action','button');
        \Blade::component('components.card',        'card');
    }
}
