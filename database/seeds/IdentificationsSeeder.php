<?php

use App\IdentificationType;
use Illuminate\Database\Seeder;

class IdentificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IdentificationType::create([
            'model' => 'App\User', 'name' => 'RUT',
        ]);
    }
}
