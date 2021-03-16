<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Identification extends MorphPivot 
{
	use SoftDeletes;

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
}