<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pausa extends Model
{
    public $primaryKey = 'idPausa';
    protected $table = 'pausa';

    public function productos()
    {
        return $this->belongsTo('App\Producto');
    }
    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador');
    }
}
