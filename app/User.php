<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

use App\Notifications\ResetPassword;

use App\Traits\SaveLower;
use App\Traits\Identifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, 
        Notifiable, 
        HasRoles, 
        SoftDeletes, 
        SaveLower,
        Identifiable;

    protected $dates = [
        'email_verified_at',
        'last_login_at',
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
        'company_id', 
        'name', 
        'rut', 
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
        'password', 
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts    = [
        'attr'              => 'array',
        'email_verified_at' => 'date:d-m-Y h:i A',
        'last_login_at'     => 'date:d-m-Y h:i A',
        'created_at'        => 'date:d-m-Y h:i A',
        'updated_at'        => 'date:d-m-Y h:i A',
        'deleted_at'        => 'date:d-m-Y h:i A',
    ];

    public function setPasswordAttribute($value)
    {
        if( $value != "" )
        {
            $this->attributes['password'] = bcrypt( $value );
        }
    }

    public function company()
    {
        return $this->belongsTo( Company::class );
    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    public function logs()
    {
        return $this->morphMany( Log::class, 'loggable');
    }

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new ResetPassword($token));
    }
}
