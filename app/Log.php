<?php

namespace App;

use App\User;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

class Log extends MongoModel
{
    //protected $table     = 'logs';
    protected $collection = 'logs';
    protected $connection = 'mongodb';
    protected $fillable  = [ 'user_id', 'event', 'description', 'ip', 'attr'];
    protected $dates     = [ 'created_at','updated_at'];
    protected $casts     = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A'
      ];

    public function getUserAttribute( $value )
	{
        return User::find( $this->user_id );
	    //return $this->belongsTo(User::class);
	}

	public function setAttrAttribute( $value )
    {
        $this->attributes['attr'] = json_encode( $value );
    }
}