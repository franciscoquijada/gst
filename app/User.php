<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;
use App\Traits\SaveLower;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, Auditable, SaveLower;

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut', 
        'department_id', 
        'phone', 
        'name', 
        'email', 
        'password', 
        'attr',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password', 
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts    = [
        'attr'              => 'json',
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
    ];

    //protected $appends  = ['is_boss'];

    public function department()
    {
        return $this->belongsTo( 'App\Department' );
    }

    public function logs()
    {
        return $this->hasMany( Log::class );
    }

    /**
     * Encode an array to a JSON string
     * 
     * @param $value
     */
    public function setAttrAttribute( $value )
    {
        $this->attributes['attr'] = json_encode( $value );
    }

    public function setPasswordAttribute($value)
    {

        if( $value != "" )
        {
            $this->attributes['password'] = bcrypt( $value );
        }
    }

    public function setRutAttribute($value)
    {
        if( $value != "" )
        {
            $rut = preg_replace( '/[^0-9|k|K]/', '', $value );
            $this->attributes['rut'] = substr( $rut, 0, -1 ) . '-' . substr( $rut, -1 );
        }
    }

    public function setPhoneAttribute($value)
    {
        if( $value != "" )
        {
            $this->attributes['phone'] = preg_replace( '/[^0-9]/', '', $value );
        }
    }
}
