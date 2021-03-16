<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Auditable;

class Meta extends Model
{
    use SoftDeletes;

    protected $table 	= 'metas';
    protected $dates 	= [ 'created_at', 'updated_at', 'deleted_at' ];

    protected $fillable = [ 'model', 'key', 'name', 'rules', 'value' ];

    protected $casts    = [
        'attr'       => 'array',
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'deleted_at' => 'date:d-m-Y h:i A',
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

    public function getRulesAttribute( $value )
    {
        return $this->attr['rules'] ?? 'nullable';
    }

    public function getInputParamsAttribute( $value )
    {
        $params = '';
        if( isset( $this->attr['input_params'] ) && is_array( $this->attr['input_params'] ) )
            foreach ( $this->attr['input_params'] as $param )
            {
                $attr    =  explode( ':', $param )[0] ?? '';
                $value   =  explode( ':', $param )[1] ?? '';
                $params .= " {$attr}={$value}";
            }

        return $params;
    }
}