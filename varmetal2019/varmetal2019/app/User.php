<?php

namespace Varmetal;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Varmetal\Notifications\MyResetPassword;

class User extends Authenticatable
{
    const ADMIN_TYPE = 'Admin';
    const SUPERVISOR_TYPE = 'Supervisor';
    const DEFAULT_TYPE = 'Trabajador';

    public function trabajador()
    {
        return $this->hasOne('Varmetal\Trabajador', 'users_id_user');
    }

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isTrabajador()
    {
        return $this->type === self::DEFAULT_TYPE;
    }

    public function isSupervisor()
    {
        return $this->type === self::SUPERVISOR_TYPE;
    }

    public static function createPassword($length)
    {
        $key = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $max = strlen($caracteres) - 1;
        for ($i=0;$i<$length;$i++)
            $key .= substr($caracteres, rand(0, $max), 1);
        return $key;
    }

    public function validateData($var)
    {
        if($var == NULL)
            return false;
        return true;
    }

    public function sendPasswordResetNotification($token)
    {
      $this->notify(new MyResetPassword($token));
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
