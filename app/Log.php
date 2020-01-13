<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table 	= 'logs';
    protected $fillable = [ 'user_id', 'event', 'description', 'ip', 'attr'];
    protected $dates    = [ 'created_at','updated_at'];
    protected $casts    = [
        'attr'       => 'array',
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A'
      ];

    public function user()
	{
	    return $this->belongsTo('App\User', 'user_id');
	}

	public function setAttrAttribute( $value )
    {
        $this->attributes['attr'] = json_encode( $value );
    }
}