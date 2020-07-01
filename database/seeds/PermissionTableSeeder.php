<?php

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
        // Users
        Permission::create(['name' => 'usuarios:listado']);
        Permission::create(['name' => 'usuarios:ver']);
        Permission::create(['name' => 'usuarios:crear']);
        Permission::create(['name' => 'usuarios:actualizar']);
        Permission::create(['name' => 'usuarios:eliminar']);
        Permission::create(['name' => 'usuarios:token']);

        // Roles
        Permission::create(['name' => 'roles:listado']);
        Permission::create(['name' => 'roles:ver']);
        Permission::create(['name' => 'roles:crear']);
        Permission::create(['name' => 'roles:actualizar']);
        Permission::create(['name' => 'roles:eliminar']);

        // Grupos
        Permission::create(['name' => 'grupos:listado']);
        Permission::create(['name' => 'grupos:crear']);
        Permission::create(['name' => 'grupos:actualizar']);
        Permission::create(['name' => 'grupos:eliminar']);

        // Tipos de identificadores
        Permission::create(['name' => 'tipos identificadores:listado']);
        Permission::create(['name' => 'tipos identificadores:crear']);
        Permission::create(['name' => 'tipos identificadores:actualizar']);
        Permission::create(['name' => 'tipos identificadores:eliminar']);

        // Notificaciones
        Permission::create(['name' => 'notificaciones:sample 1']);

        // Logs
        Permission::create(['name' => 'registros:listado']);

        // Settings
        Permission::create(['name' => 'configuraciones:listado']);  

        // Roles
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo( Permission::all() );
    }
}
