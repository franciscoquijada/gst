<?php

use App\User;
use App\Company;
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
$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'created_at' => \Carbon\Carbon::now()
    ];
});

$factory->define(User::class, function (Faker $faker) {
    return [
        'company_id'        => App\Company::first()->id,
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'password'          => 'secret', // password
        'remember_token'    => Str::random(10),
        'attr'              => '',
    ];
});
