<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PNotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pnotify', function()
        {
            return $this->app->make('App\Library\Services\PNotifier');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom( base_path('Resources/views/services'), 'PNotify');
    }
}
