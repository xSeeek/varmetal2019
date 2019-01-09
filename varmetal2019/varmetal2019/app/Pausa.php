<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Pausa extends Model
{
    public $primaryKey = 'idPausa';
    protected $table = 'pausa';

    public function producto()
    {
        return $this->belongsTo('Varmetal\Producto','producto_id_producto');
    }
    public function trabajador()
    {
        return $this->belongsTo('Varmetal\Trabajador','trabajador_id_trabajador');
    }
}
