<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
	use SoftDeletes;

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table    = 'languages';
    protected $fillable = [ 'name' ];
    protected $dates    = [ 'created_at', 'updated_at', 'deleted_at' ];
    protected $casts    = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'deleted_at' => 'date:d-m-Y h:i A',
    ];
}
