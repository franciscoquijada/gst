<?php

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

      DB::table('departments')->insert([
        'name'        => 'IT',
        'created_at'  => now()
      ]);

      DB::table('users')->insert([
          'rut'               => '00000000-0',
          'department_id'     =>  App\Department::first()->id,
          'name'              => 'administrador',
          'phone'             => '00000000000',
          'email'             => 'admin@admin.cl',
          'email_verified_at' => now(),
          'attr'              => '',
          'password'          => Hash::make('admin'),
          'remember_token'    => Str::random(10),
          'created_at'        => now()
      ]);
    }
}
