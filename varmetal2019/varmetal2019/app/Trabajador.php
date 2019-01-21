<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    public $primaryKey = 'idTrabajador';
    protected $table = 'trabajador';

    public function obraWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Obra', 'obra_supervisor', 'trabajador_id_trabajador', 'obras_id_obra')->withPivot('tiempoPerdido', 'tiempoSetUp');
    }
    public function obra()
    {
        return $this->belongsToMany('Varmetal\Obra', 'obra_supervisor', 'trabajador_id_trabajador', 'obras_id_obra');
    }
    public function user()
    {
        return $this->belongsTo('Varmetal\User', 'users_id_user');
    }
    public function pausa()
    {
        return $this->hasMany('Varmetal\Pausa','pausa_id_pausa');
    }
    public function producto()
    {
        return $this->belongsToMany('Varmetal\Producto', 'trabajadores_producto', 'trabajador_id_trabajador', 'producto_id_producto');
    }
    public function productoWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Producto', 'trabajadores_producto', 'trabajador_id_trabajador', 'producto_id_producto')->withPivot('fechaComienzo', 'kilosTrabajados', 'pausasRealizadas', 'productosRealizados');
    }
    public function productoIncompleto()
    {
        $instance = $this->belongsToMany('Varmetal\Producto', 'trabajadores_producto', 'trabajador_id_trabajador', 'producto_id_producto');
        $instance->getQuery()->where('estado', '<>', 1);
        return $instance;
    }
    public function validateData($var)
    {
        if($var == NULL)
            return false;
        return true;
    }
}
