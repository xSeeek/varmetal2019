<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $primaryKey = 'idObra';
    protected $table = 'obra';

    public function producto()
    {
        return $this->hasMany('Varmetal\Producto', 'obras_id_obra');
    }
    public function supervisor()
    {
      return $this->belongsToMany('Varmetal\Trabajador', 'obra_supervisor', 'trabajador_id_trabajador', 'obras_id_obra');
    }
    public function trabajador()
    {
      $this->hasMany('Varmetal\Trabajador','trabajador_id_trabajador');
    }
}
