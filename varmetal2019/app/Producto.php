<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $primaryKey = 'idProducto';
    protected $table = 'producto';

    public function conjunto()
    {
        return $this->belongsTo('Varmetal\ConjuntoProducto', 'conjunto_id_conjunto');
    }
    public function trabajador()
    {
       return $this->belongsToMany('Varmetal\Trabajador', 'productos_trabajador', 'producto_id_producto', 'trabajador_id_trabajador');
    }
   public function trabajadorWithAtributtes()
    {
       return $this->belongsToMany('Varmetal\Trabajador', 'productos_trabajador', 'producto_id_producto', 'trabajador_id_trabajador')->withPivot('fechaComienzo', 'kilosTrabajados', 'productosRealizados');
    }
    public function pausa()
    {
        return $this->hasMany('Varmetal\Pausa','producto_id_producto');
    }
    public function obra()
    {
        return $this->belongsTo('Varmetal\Obra', 'obras_id_obra');
    }
    public function tipo()
    {
        return $this->belongsTo('Varmetal\Tipo', 'tipo_id_tipo');
    }
    public function material()
    {
       return $this->belongsToMany('Varmetal\Material', 'materiales_gastados', 'producto_id_producto', 'material_id_material');
    }
    public function materialWithAtributes()
    {
        return $this->belongsToMany('Varmetal\Material', 'materiales_gastados', 'producto_id_producto', 'material_id_material')->withPivot('gastado', 'fechaTermino','trabajador_id_trabajador');
    }
    public function pintado()
    {
        return $this->hasMany('Varmetal\Pintado','producto_id_producto');
    }
}
