<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Pausa extends Model
{
    public $primaryKey = 'idPausa';
    protected $table = 'pausa';

    public function productos()
    {
        return $this->belongsTo('Varmetal\Producto');
    }
    public function trabajador()
    {
        return $this->belongsTo('Varmetal\Trabajador');
    }
}
