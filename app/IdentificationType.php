<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class IdentificationType extends Model
{
	use SoftDeletes, Auditable;

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

    public function getInputClassesAttribute( $value )
    {
        $class = '';
        if( isset( $this->attr['input_classes'] ) && is_array( $this->attr['input_classes'] ) )
            $class .= implode(' ', $this->attr['input_classes'] );

        return $class;
    }
}