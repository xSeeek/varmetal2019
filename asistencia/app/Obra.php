<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $primaryKey = 'idObra';
    protected $table = 'obra';

    public function encargado()
    {
      return $this->belongsTo('Asistencia\Trabajador', 'encargado_id_encargado');
    }

    public function asistencias()
    {
      return $this->hasMany('Asistencia\Asistencia', 'obra_id_obra');
    }
}
