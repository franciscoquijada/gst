<?php

namespace Database\Seeders;

use App\User;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Company::create(['name' => 'Centribal']);

    User::create([
        'company_id'        =>  Company::first()->id,
        'name'              => 'administrador',
        'email'             => 'admin@admin.cl',
        'password'          => 'admin',
        'remember_token'    => \Str::random(10)
    ])->assignRole([ config('permission.admin', 'administrador') ]);
  }
}