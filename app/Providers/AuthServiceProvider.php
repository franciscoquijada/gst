<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Spatie\Permission\Models\Permission;
use Laravel\Passport\Passport;

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

        Passport::routes();
        
        $gate->before( function ( $user, $ability )
        {
            if( app()->environment() === 'local' )
            {
                if( Permission::where( 'name', $ability )->count() == 0 )
                    $this->savePermission($ability);
            }

            if ( $user->hasRole( config('permission.admin', 'administrador') ) )
            {
                return true;
            }
        });
    }

    public function savePermission( $permission )
    {
        $permission_file = config( 'permission.folder', __DIR__ . '/../../database/seeders/data/permissions.csv');
        $permissions     = \Arr::flatten( array_map('str_getcsv', file($permission_file)));

        if( ! in_array( $permission, $permissions ) &&
            file_exists( $permission_file ) && 
            is_writable( $permission_file ) 
        )
            file_put_contents( $permission_file , "{$permission}\n", FILE_APPEND );
    }
}
