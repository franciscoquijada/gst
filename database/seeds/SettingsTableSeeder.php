<?php
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
        $settings = [
            [
                'key'           => 'company_logo',
                'name'          => 'logo de la empresa',
                'value'         => '#',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => [ 'string' ]
                ]
            ],[
                'key'           => 'company_logo_menu',
                'name'          => 'logo de la empresa (Menu)',
                'value'         => '#',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => [ 'string' ]
                ]
            ],[
                'key'           => 'company_favicon',
                'name'          => 'icono de la empresa',
                'value'         => '#',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => [ 'string' ]
                ]
            ],[
                'key'           => 'color_primary',
                'name'          => 'color principal',
                'value'         => '#36B9CC',
                'description'   => 'Color principal del tema',
                'field'         => [ 
                    'type'      => 'color',
                    'validate'  => 'string'
                ]
            ],[
                'key'           => 'group_default',
                'name'          => 'Grupo por defecto',
                'value'         => '#36B9CC',
                'description'   => 'Grupo por defecto (autoregistro)',
                'field'         => [ 
                    'type'      => 'number',
                    'validate'  => 'numeric'
                ]
            ],[
                'key'           => 'role_default',
                'name'          => 'Rol por defecto',
                'value'         => '#36B9CC',
                'description'   => 'Rol por defecto (autoregistro)',
                'field'         => [ 
                    'type'      => 'number',
                    'validate'  => 'numeric'
                ]
            ],[
                'key'           => 'auto_register',
                'name'          => 'Auto-Registro',
                'value'         => '#36B9CC',
                'description'   => 'Usuarios puede autoregistrarse',
                'field'         => [ 
                    'type'      => 'bolean',
                    'validate'  => 'bolean'
                ]
            ]
        ];

        foreach ( $settings as $setting )
            Setting::create( $setting );
    }
}
