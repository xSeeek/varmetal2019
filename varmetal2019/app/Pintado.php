<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Pintado extends Model
{
    public $primaryKey = 'idPintura';
    protected $table = 'pintura';

    public function pintor()
    {
        return $this->belongsTo('Varmetal\Trabajador', 'pintor_id_trabajador');
    }

    public function producto()
    {
        return $this->belongsTo('Varmetal\Producto', 'producto_id_producto');
    }

    public function supervisor()
    {
        return $this->belongsTo('Varmetal\Trabajador', 'supervisor');
    }
}
