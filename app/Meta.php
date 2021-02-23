<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Auditable;
use App\Traits\SaveLower;

class Meta extends Model
{
    use SoftDeletes, SaveLower;

    protected $table 	= 'meta';
    protected $dates 	= [ 'created_at', 'updated_at', 'deleted_at' ];

    protected $fillable = ['key', 'value'];

    protected $casts     = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
    ];

    public function metable()
    {
    	return $this->morphTo();
    }

    public function setValueAttribute( $value )
    {
        $this->attributes['value'] = strtolower( json_encode($value) ?? $value );
    }

    public function getValueAttribute( $value )
    {
        return json_decode( $value ) ?? $value;
    }
}