<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    public $primaryKey = 'idTrabajador';
    protected $table = 'trabajador';

    public function user()
    {
        return $this->belongsTo('Varmetal\User', 'users_id_user');
    }
    public function pausa()
    {
        return $this->hasMany('Varmetal\Pausa');
    }
    public function producto()
    {
        return $this->belongsToMany('Varmetal\Producto', 'trabajadores_producto', 'trabajador_id_trabajador', 'producto_id_producto');
    }
    public function validateData($var)
    {
        if($var == NULL)
            return false;
        return true;
    }
}
