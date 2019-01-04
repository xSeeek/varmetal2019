<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $primaryKey = 'idProducto';
    protected $table = 'producto';

    public function trabajador()
    {
        return $this->belongsToMany('Varmetal\Producto');
    }
    public function pausa()
    {
        return $this->hasMany('Varmetal\Pausa');
    }
}
