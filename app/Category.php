<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Auditable;
use App\Traits\SaveLower;

class Category extends Model
{
	use SoftDeletes, Auditable, SaveLower;

    protected $dates 	= [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $fillable = [ 'name', 'attr'];

	public function categorizable()
    {
        return $this->morphTo();
    }
}
