<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IdentificationType extends Model
{
	use SoftDeletes;

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table    = 'identifications_types';
    protected $fillable = [ 'model', 'name', 'attr' ];
    protected $dates    = [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $casts    = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'deleted_at' => 'date:d-m-Y h:i A',
        'attr'       => 'array',
    ];

    public function users()
    {
        return $this->morphedByMany('App\User', 'identifications');
    }

    public function clients()
    {
        return $this->morphedByMany('App\Client', 'identifications');
    } 
}