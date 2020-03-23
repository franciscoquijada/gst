<?php

use App\User;
use App\Department;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'created_at' => \Carbon\Carbon::now()
    ];
});

$factory->define(User::class, function (Faker $faker) {
    return [
        'rut'               => '00000000-0',
        'department_id'     => factory(Department::class),
        'name'              => $faker->name,
        'phone'             => '00000000000',
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => 'secret', // password
        'remember_token'    => Str::random(10),
        'attr'              => '',
        'created_at'        => now()
    ];
});
