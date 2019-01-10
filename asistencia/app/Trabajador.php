<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
  public $primaryKey = 'idTrabajador';
  protected $table = 'trabajador';

  protected $fillable = [
      'rut',
  ];

  public function user()
  {
      return $this->belongsTo('Asistencia\User', 'users_id_user');
  }

  public function asistencias()
  {
    return $this->hasMany('Asistencia\Asistencia', 'trabajador_id_trabajador');
  }

  public function obra()
  {
    return $this->belongsTo('Asistencia\Obra', 'obra_id_obra');
  }

  public function validateData($var)
  {
      if($var == NULL)
          return false;
      return true;
  }
}
