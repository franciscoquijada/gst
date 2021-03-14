<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Auditable;
use App\Traits\SaveLower;

class Meta extends Model
{
    use SoftDeletes;

    protected $table 	= 'metas';
    protected $dates 	= [ 'created_at', 'updated_at', 'deleted_at' ];

    protected $fillable = [ 'model', 'key', 'name', 'rules', 'value' ];

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
        $this->attributes['value'] = json_encode($value) ?? $value;
    }

    public function getValueAttribute( $value )
    {
        return json_decode( $value ) ?? $value;
    }
}
