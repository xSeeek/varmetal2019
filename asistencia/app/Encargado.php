<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
  protected $table = "encargado";
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
