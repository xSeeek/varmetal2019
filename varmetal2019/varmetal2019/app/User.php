<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ADMIN_TYPE = 'Admin';
    const DEFAULT_TYPE = 'Trabajador';

    public function trabajador()
    {
        return $this->hasOne('App\Trabajador');
    }

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isTrabajador()
    {
        return $this->type === self::DEFAULT_TYPE;
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
