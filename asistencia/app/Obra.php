<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $primaryKey = 'idObra';
    protected $table = 'obra';

    public function trabajadores()
    {
      return $this->hasMany('Asistencia\Trabajador', 'obra_id_obra');
    }
}
