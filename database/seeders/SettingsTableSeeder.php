<?php

namespace Database\Seeders;

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add Init Settings
        include( __DIR__ . "/data/settings.php");
        
        if( isset( $settings ) )
            foreach ( $settings as $setting )
                Setting::create( $setting );
    }
}
