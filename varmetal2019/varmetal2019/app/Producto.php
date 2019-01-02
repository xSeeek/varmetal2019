<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $primaryKey = 'idProducto';
    protected $table = 'producto';

    public function trabajador()
    {
        return $this->belongsToMany('App\Producto');
    }
    public function pausa()
    {
        return $this->hasMany('App\Pausa');
    }
}
