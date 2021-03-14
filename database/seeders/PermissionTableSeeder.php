<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add Permissions
        $permissions_file = config( 'permission.folder', __DIR__ . "/data/permissions.csv" );
        $permissions      = array_map('str_getcsv', file($permissions_file));

        if( isset( $permissions ) )
            foreach ( $permissions as $permission )
                Permission::create(['name' => $permission[0] ]);  

        //Add Admin Rol
        $role = Role::create(['name' => config('permission.admin', 'administrador') ]);
        $role->givePermissionTo( Permission::all() );
    }
}
