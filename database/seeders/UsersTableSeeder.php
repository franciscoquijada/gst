<?php

namespace Database\Seeders;

use App\User;
use App\Group;
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
    Group::create(['name' => 'Default']);

    User::create([
        'group_id'          =>  Group::first()->id,
        'name'              => 'administrador',
        'email'             => 'admin@admin.cl',
        'password'          => 'admin',
        'remember_token'    => \Str::random(10)
    ])->assignRole([ config('permission.admin', 'administrador') ]);
  }
}