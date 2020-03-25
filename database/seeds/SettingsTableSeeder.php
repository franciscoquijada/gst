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
                'key'           => 'company_rut',
                'name'          => 'rut de la empresa',
                'value'         => '',
                'description'   => 'ej. 12.345.678-9',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => [ 'unique:settings,value,NULL,id,deleted_at,NULL', 'string', 'new ValidarRut' ]
                ]
            ],[
                'key'           => 'company_logo',
                'name'          => 'logo de la empresa',
                'value'         => '',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'image',
                    'validate'  => [ 'unique:settings,value,NULL,id,deleted_at,NULL', 'string', 'new ValidarRut' ]
                ]
            ],[
                'key'           => 'company_logo_menu',
                'name'          => 'logo de la empresa (Menu)',
                'value'         => '',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'image',
                    'validate'  => [ 'unique:settings,value,NULL,id,deleted_at,NULL', 'string', 'new ValidarRut' ]
                ]
            ],[
                'key'           => 'company_favicon',
                'name'          => 'icono de la empresa',
                'value'         => '',
                'description'   => '',
                'field'         => [ 
                    'type'      => 'image',
                    'validate'  => [ 'unique:settings,value,NULL,id,deleted_at,NULL', 'string', 'new ValidarRut' ]
                ]
            ],[
                'key'           => 'company_name',
                'name'          => 'razon social',
                'value'         => '',
                'description'   => 'nombre o razon social de la empresa',
                'field'         => [ 
                    'type' => 'text',
                    'validate'  => 'required|string' 
                ]
            ],[
                'key'           => 'company_phone',
                'name'          => 'telefono',
                'value'         => '',
                'description'   => 'telefono de la empresa',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => 'required|number'
                ]
            ],[
                'key'           => 'company_email',
                'name'          => 'email',
                'value'         => '',
                'description'   => 'email de contacto',
                'field'         => [ 
                    'type'      => 'email',
                    'validate'  => 'required|email'
                ]
            ],[
                'key'           => 'bg_login',
                'name'          => 'Imagen Login',
                'value'         => '',
                'description'   => 'Imagen del login',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => 'string'
                ]
            ],[
                'key'           => 'color_primary',
                'name'          => 'Color Principal',
                'value'         => '#36B9CC',
                'description'   => 'Color de fondo',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => 'string'
                ]
            ],[
                'key'           => 'company_giro',
                'name'          => 'giro',
                'value'         => '',
                'description'   => 'giro de la empresa',
                'field'         => [ 
                    'type'      => 'text',
                    'validate'  => 'required|string'
                ]
            ]
        ];

        foreach ( $settings as $setting )
            Setting::create( $setting );
    }
}
