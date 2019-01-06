<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
  public $primaryKey = 'idAsistencia';
  protected $table = 'asistencia';

  public function trabajador()
  {
    return $this->belongsToMany('Asistencia\Trabajador', 'asistencias_trabajador', 'trabajador_id_trabajador', 'asistencia_id_asistencia');
  }
}
