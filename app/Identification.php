<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Identification extends MorphPivot 
{
	use SoftDeletes;

    protected $validation_errors = [
        'required' => 'Este campo es obligatorio',
        'unique'   => 'Este valor ya se encuentra registrado',
    ];

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table    = 'identifications';
    protected $fillable = [ 'identification_type_id', 'value', 'attr' ];
    protected $dates    = [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $with     = [ 'type' ];
    protected $casts    = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'deleted_at' => 'date:d-m-Y h:i A',
        'attr'       => 'array',
    ];

    public function identifications()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo( IdentificationType::class, 'identification_type_id' );
    }

    public function validateIdentifications( $request, $model, $id = 0 )
    {
        $identifications = [];

        foreach ( $request['external'] AS $type_id => $value )
        {

            $identification_type = IdentificationType::findOrFail( $type_id );

            $value  = preg_replace( '/[^0-9|k|K]/', '',$value );

            $unique = Rule::unique('identifications', 'value')
                ->ignore( $id, 'identifications_id')
                ->where( function ( $query ) use ( $model )
            {
                return $query->where( 'identifications_type', $model );
            });

            \Validator::make(
                [
                    'external'   => [ $type_id => $value ]
                ],
                [
                    'external.*' => array_merge( 
                        $identification_type->attr['rules'], 
                        [$unique] 
                    )
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