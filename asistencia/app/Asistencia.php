<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
  protected $fillable = [
      'image',
  ];
  public $primaryKey = 'idAsistencia';
  protected $table = 'asistencia';

  public function trabajador()
  {
    return $this->belongsTo('Asistencia\Trabajador', 'trabajador_id_trabajador');
  }

  public function obra()
  {
    return $this->belongsTo('Asistencia\Obra', 'obra_id_obra');
  }
}
