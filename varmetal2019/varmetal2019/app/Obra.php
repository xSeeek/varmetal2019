<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $primaryKey = 'idObra';
    protected $table = 'obra';

    public function producto()
    {
        return $this->hasMany('Varmetal\Producto', 'obras_id_obra');
    }
    public function supervisor()
    {
        return $this->belongsToMany('Varmetal\Trabajador', 'obra_supervisor','obras_id_obra', 'trabajador_id_trabajador');
    }

    protected $fillable = [
        'fechaFin',
    ];
}
