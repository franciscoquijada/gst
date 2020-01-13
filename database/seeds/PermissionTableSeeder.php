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
      /* Modulo de ordenes de compras */
      Permission::create(['name' => 'modulo ordenes de compras']);

      // Mis OCs
      Permission::create(['name' => 'listado de ordenes de compras']);
      Permission::create(['name' => 'ver orden de compras']);
      Permission::create(['name' => 'crear orden de compras']);
      Permission::create(['name' => 'editar orden de compras']);
      Permission::create(['name' => 'eliminar orden de compras']);
      Permission::create(['name' => 'imprimir orden de compras']);
      Permission::create(['name' => 'aprobar orden de compras']);
      Permission::create(['name' => 'rendir orden de compras']);
      Permission::create(['name' => 'pagar orden de compras']);
      Permission::create(['name' => 'rechazar orden de compras']);
      Permission::create(['name' => 'anular orden de compras']);

      // Proveedores
      Permission::create(['name' => 'listado de proveedores']);
      Permission::create(['name' => 'ver proveedores']);
      Permission::create(['name' => 'crear proveedores']);
      Permission::create(['name' => 'editar proveedores']);
      Permission::create(['name' => 'eliminar proveedores']);

      // Centros de costos
      Permission::create(['name' => 'listado de centros de costos']);
      Permission::create(['name' => 'ver centros de costos']);
      Permission::create(['name' => 'crear centros de costos']);
      Permission::create(['name' => 'editar centros de costos']);
      Permission::create(['name' => 'eliminar centros de costos']);

      /* Modulo de cuentas en ordenes de compras */
      Permission::create(['name' => 'modulo de cuentas']);

      // Categorias
      Permission::create(['name' => 'listado de categorias']);
      Permission::create(['name' => 'ver categorias']);
      Permission::create(['name' => 'crear categorias']);
      Permission::create(['name' => 'editar categorias']);
      Permission::create(['name' => 'eliminar categorias']);

      // Cuentas contables
      Permission::create(['name' => 'listado de cuentas contables']);
      Permission::create(['name' => 'ver cuentas contables']);
      Permission::create(['name' => 'crear cuentas contables']);
      Permission::create(['name' => 'editar cuentas contables']);
      Permission::create(['name' => 'eliminar cuentas contables']);

      // Metodos de pago
      Permission::create(['name' => 'listado de metodos de pago']);
      Permission::create(['name' => 'ver metodos de pago']);
      Permission::create(['name' => 'crear metodos de pago']);
      Permission::create(['name' => 'editar metodos de pago']);
      Permission::create(['name' => 'eliminar metodos de pago']);

      // Impuestos
      Permission::create(['name' => 'listado de impuestos']);
      Permission::create(['name' => 'ver impuestos']);
      Permission::create(['name' => 'crear impuestos']);
      Permission::create(['name' => 'editar impuestos']);
      Permission::create(['name' => 'eliminar impuestos']);

      // Articulos
      Permission::create(['name' => 'listado de articulos']);
      Permission::create(['name' => 'ver articulos']);
      Permission::create(['name' => 'crear articulos']);
      Permission::create(['name' => 'editar articulos']);
      Permission::create(['name' => 'eliminar articulos']);

      // Bancos
      Permission::create(['name' => 'listado de bancos']);
      Permission::create(['name' => 'ver bancos']);
      Permission::create(['name' => 'crear bancos']);
      Permission::create(['name' => 'editar bancos']);
      Permission::create(['name' => 'eliminar bancos']);
      
      // Categoria de ordenes
      Permission::create(['name' => 'listado de categoria de orden']);
      // Permission::create(['name' => 'ver categoria de orden']);
      Permission::create(['name' => 'crear categoria de orden']);
      Permission::create(['name' => 'editar categoria de orden']);
      Permission::create(['name' => 'eliminar categoria de orden']);

      /* Modulo de usuarios */

      Permission::create(['name' => 'modulo de usuarios']);

      // Users

      Permission::create(['name' => 'listado de usuarios']);
      Permission::create(['name' => 'ver usuario']);
      Permission::create(['name' => 'crear usuario']);
      Permission::create(['name' => 'actualizar usuario']);
      Permission::create(['name' => 'eliminar usuario']);

      // Roles
      Permission::create(['name' => 'listado de roles']);
      Permission::create(['name' => 'ver rol']);
      Permission::create(['name' => 'crear rol']);
      Permission::create(['name' => 'actualizar rol']);
      Permission::create(['name' => 'eliminar rol']);

      // Departamentos
      Permission::create(['name' => 'listado de departamentos']);
      Permission::create(['name' => 'ver departamento']);
      Permission::create(['name' => 'crear departamento']);
      Permission::create(['name' => 'actualizar departamento']);
      Permission::create(['name' => 'eliminar departamento']);

      /* Modulo de auditoria */
      Permission::create(['name' => 'auditoria']);

      /* Modulo de configuracion */
      Permission::create(['name' => 'modulo de configuracion']);
      Permission::create(['name' => 'configuracion empresa']);
      Permission::create(['name' => 'configuracion temas']);    

      /* Creamos el rol super-admin "Super Administrador" */
      $role = Role::create(['name' => 'super-admin']);
      $role->givePermissionTo( Permission::all() );

      User::find(1)->assignRole(['super-Admin']);
    }
}
