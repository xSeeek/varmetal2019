<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    public $primaryKey = 'idTrabajador';
    protected $table = 'trabajador';

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id_user');
    }
    public function pausa()
    {
        return $this->hasMany('App\Pausa');
    }
    public function producto()
    {
        return $this->belongsToMany('App\Producto', 'trabajadores_producto', 'trabajador_id_trabajador', 'producto_id_producto');
    }
    public function validateData($var)
    {
        if($var == NULL)
            return false;
        return true;
    }
}
