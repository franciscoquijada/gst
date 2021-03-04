<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Auditable;
use App\Traits\SaveLower;

class Group extends Model
{
    use SoftDeletes, Auditable, SaveLower;

    protected $table 	= 'groups';
    protected $dates 	= [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $fillable = [ 'name', 'attr'];

    public function users()
    {
    	return $this->hasMany( User::class );
    }

}
