<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    protected $table     = 'logs';
    //protected $collection = 'logs';
    //protected $connection = 'mongodb';
    protected $fillable  = [ 'user_id', 'event', 'description', 'ip', 'attr'];
    protected $dates     = [ 'created_at','updated_at'];
    protected $casts     = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A'
    ];
    protected $appends   = ['user_name'];
    protected $with      = [ 'user' ];

    public function getUserNameAttribute( $value )
	{
        return $this->user->name ?? 'N/A';
	}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

	public function setAttrAttribute( $value )
    {
        $this->attributes['attr'] = json_encode( $value );
    }
}