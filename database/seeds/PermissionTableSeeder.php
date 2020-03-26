<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        Permission::create(['name' => 'usuarios:listado']);
        Permission::create(['name' => 'usuarios:ver']);
        Permission::create(['name' => 'usuarios:crear']);
        Permission::create(['name' => 'usuarios:actualizar']);
        Permission::create(['name' => 'usuarios:eliminar']);

        // Roles
        Permission::create(['name' => 'roles:listado']);
        Permission::create(['name' => 'roles:ver']);
        Permission::create(['name' => 'roles:crear']);
        Permission::create(['name' => 'roles:actualizar']);
        Permission::create(['name' => 'roles:eliminar']);

        // Departments
        Permission::create(['name' => 'departamentos:listado']);
        Permission::create(['name' => 'departamentos:crear']);
        Permission::create(['name' => 'departamentos:actualizar']);
        Permission::create(['name' => 'departamentos:eliminar']);

        // Logs
        Permission::create(['name' => 'registros:listado']);

        // Settings
        Permission::create(['name' => 'configuraciones:listado']);  

        // Create Super-Admin
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo( Permission::all() );

        User::find(1)->assignRole(['super-admin']);
    }
}
