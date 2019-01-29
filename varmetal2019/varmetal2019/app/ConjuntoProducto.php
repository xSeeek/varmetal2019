<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class ConjuntoProducto extends Model
{
    public $primaryKey = 'idConjunto';
    protected $table = 'conjunto_producto';

    public function productos()
    {
        return $this->hasMany('Varmetal\Producto', 'conjunto_id_conjunto');
    }
    public function trabajador()
    {
        return $this->belongsToMany('Varmetal\Trabajador', 'trabajadores_producto', 'conjunto_id_conjunto', 'trabajador_id_trabajador');
    }
    public function trabajadorWithAtributtes()
    {
        return $this->belongsToMany('Varmetal\Trabajador', 'trabajadores_producto', 'conjunto_id_conjunto', 'trabajador_id_trabajador')->withPivot('fechaComienzo', 'kilosTrabajados', 'pausasRealizadas', 'productosRealizados');
    }
}
