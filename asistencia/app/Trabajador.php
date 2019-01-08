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
  public function validateData($var)
  {
      if($var == NULL)
          return false;
      return true;
  }
}
