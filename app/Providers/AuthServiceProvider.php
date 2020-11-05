<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot( GateContract $gate )
    {
        $this->registerPolicies();
        
        $gate->before( function ( $user, $ability )
        {
            if( app()->environment() === 'local' )
            {
                if( Permission::where( 'name', $ability )->count() == 0 )
                    Permission::create(['name' => $ability]);
            }

            if ( $user->hasRole( config('permission.admin', 'administrador') ) )
            {
                return true;
            }
        });
    }
}
