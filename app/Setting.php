<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Setting extends Model
{
	use SoftDeletes, Auditable;

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table    = 'settings';
    protected $fillable = [ 'value' ];
    protected $dates    = [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $casts    = [
        'value'      => 'array',
        'field'      => 'array',
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'deleted_at' => 'date:d-m-Y h:i A'
      ];
    
    /**
     * Encode an array to a JSON string
     * 
     * @param $value
     */
    
    public function setValueAttribute( $value )
    {
        $this->attributes['value'] = json_encode( $value );
    }
}
