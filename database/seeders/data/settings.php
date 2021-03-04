<?php 
/*
 	Configuracion inicial
 */
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