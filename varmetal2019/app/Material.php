<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
  public $primaryKey = 'idMaterial';
  protected $table = 'material';

  public function trabajador()
  {
     return $this->belongsToMany('Varmetal\Trabajador', 'materiales_gastados', 'material_id_material', 'trabajador_id_trabajador');
  }
  public function trabajadorWithAtributtes()
  {
     return $this->belongsToMany('Varmetal\Trabajador', 'materiales_gastados', 'material_id_material', 'trabajador_id_trabajador')->withPivot('gastado');
  }
}
