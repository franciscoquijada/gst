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
        include( __DIR__ . "/data/permissions.php");

        if( isset( $permissions ) )
            foreach ( $permissions as $permission )
                Permission::create($permission);  

        //Add Admin Rol
        $role = Role::create(['name' => config('permission.admin', 'administrador') ]);
        $role->givePermissionTo( Permission::all() );
    }
}
