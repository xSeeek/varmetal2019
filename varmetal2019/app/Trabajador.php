<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Trabajador extends Model
{
    public $primaryKey = 'idTrabajador';
    protected $table = 'trabajador';

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
        return $this->hasMany('Varmetal\Pausa','trabajador_id_trabajador');
    }
    public function conjunto()
    {
        return $this->belongsToMany('Varmetal\ConjuntoProducto', 'trabajadores_conjunto', 'trabajador_id_trabajador', 'conjunto_id_conjunto');
    }
    public function conjuntoWithAtributtes()
    {
        return $this->belongsToMany('Varmetal\ConjuntoProducto', 'trabajadores_conjunto', 'trabajador_id_trabajador', 'conjunto_id_conjunto')->withPivot('fechaComienzo');
    }
    public function producto()
    {
        return $this->belongsToMany('Varmetal\Producto', 'productos_trabajador', 'trabajador_id_trabajador', 'producto_id_producto');
    }
    public function productoSoldador()
    {
        return $this->belongsToMany('Varmetal\Producto', 'productos_soldador', 'trabajador_id_trabajador', 'producto_id_producto');
    }
    public function material()
    {
        return $this->belongsToMany('Varmetal\Material', 'materiales_gastados', 'trabajador_id_trabajador', 'material_id_material');
    }
    public function productoWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Producto', 'productos_trabajador', 'trabajador_id_trabajador', 'producto_id_producto')->withPivot('fechaComienzo', 'kilosTrabajados', 'productosRealizados');
    }
    public function productoSoldadorWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Producto', 'productos_soldador', 'trabajador_id_trabajador', 'producto_id_producto')->withPivot('fechaComienzo', 'kilosTrabajados', 'productosRealizados');
    }
    public function materialWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Material', 'materiales_gastados', 'trabajador_id_trabajador', 'material_id_material')->withPivot('gastado', 'fechaTermino','trabajador_id_trabajador','producto_id_producto','material_id_material');
    }
    public function productoIncompleto()
    {
        $instance = $this->belongsToMany('Varmetal\Producto', 'productos_trabajador', 'trabajador_id_trabajador', 'producto_id_producto');
        $instance->getQuery()->where('terminado', 'false');
        return $instance;
    }
    public function productosCompletosMesActual()
    {
        $date = new Carbon();
        $instance = $this->belongsToMany('Varmetal\Producto', 'productos_trabajador', 'trabajador_id_trabajador', 'producto_id_producto')->withPivot('fechaComienzo', 'kilosTrabajados', 'productosRealizados');;
        $instance->getQuery()->where('terminado', 'true')->whereMonth('fechaFin', $date->now()->month);
        return $instance;
    }
    public function ayudante()
    {
        return $this->hasMany('Varmetal\Ayudante', 'lider_id_trabajador');
    }
    public function validateData($var)
    {
        if($var == NULL)
            return false;
        return true;
    }
}
