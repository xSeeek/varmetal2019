<?php

namespace Asistencia;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
  protected $table = "trabajador";
  public function user()
  {
    $this->belongsTo('Asistencia\User');
  }
}
