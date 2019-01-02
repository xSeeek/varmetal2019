<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    public function user()
    {
        return $this->belongsTo('App/User');
    }
    public function pausa()
    {
        return $this->hasMany('App/Pausa');
    }
    public fuction producto()
    {
        return $this->belongsToMany('App/Producto');
    }
}
