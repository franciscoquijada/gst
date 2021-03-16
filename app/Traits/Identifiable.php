<?php

namespace App\Traits;

use App\IdentificationType;
use App\Identification;

trait Identifiable
{
    //TODO: Centralizar
    protected $validation_errors = [
        'required' => 'Este campo es obligatorio',
        'unique'   => 'Este valor ya se encuentra registrado',
    ];

	public function initializeIdentifiable()
    {
        $this->with[] 		= 'identifications';
        $this->appends[]    = 'external_html';
        $this->appends[]    = 'externals';
    }

    public function identifications()
    {
        return $this->morphMany(Identification::class, 'identifications');
    }

	public function identificationstypes()
    {
        return $this->morphToMany( IdentificationType::class, 'identifications')
        	->using( Identification::class )
        	->withTimestamps();
    }

    public function getExternalsAttribute()
    {
        $identifications = [];

        $this->identifications->each( function( $item ) use( &$identifications )
        {
            $identifications[ $item->type->id ] = [
                'type'  => $item->type->name,
                'value' => $item->value,
            ];
        });

        return $identifications;
    }

    public function getExternalHtmlAttribute()
    {
        return view('components.identifications.list', [ 
            'identifications' => $this->identifications 
        ])->render();
    }

    public function validateIdentifications()
    {
        $request = request()->all();
        $model   = get_class( $this );
        $id      = $this->id ?? NULL;

        $identifications = [];

        foreach ( $request['external'] AS $type_id => $value )
        {
            $identification_type = IdentificationType::findOrFail( $type_id );

            $value   = preg_replace( '/[^0-9|k|K]/', '',$value );
            $rules   = $identification_type->attr['rules'];
            $rules[] = "unique:identifications,value,{$id},identifications_id,deleted_at,NULL,identifications_type,{$model}";

            \Validator::make(
                [
                    'external'   => [ $type_id => $value ]
                ],
                [
                    'external.*' => $rules
                ], 
                $this->validation_errors )
                ->validate();

            if( !empty( $value ) )
                $identifications[ $type_id ] = [ 
                    'value' =>  $value
                ];
        }

        return $identifications;
    }
}