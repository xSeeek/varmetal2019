<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
  protected $table = "trabajador";
  public function user()
  {
    $this->belongsTo('App\User');
  }
}
