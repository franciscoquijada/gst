<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table     = 'logs';
    protected $fillable  = [ 'loggable_id', 'loggable_type', 'event', 'description', 'ip', 'attr'];
    protected $dates     = [ 'created_at','updated_at'];
    protected $casts     = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'attr'      => 'array'
    ];
    protected $with      = [ 'loggable' ];

    public function loggable()
    {
        return $this->morphTo();
    }
}