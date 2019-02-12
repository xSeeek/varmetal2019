<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Ayudante extends Model
{
    public $primaryKey = 'idAyudante';
    protected $table = 'ayudantes';

    public function lider()
    {
        return $this->belongsTo('Varmetal\Trabajador', 'lider_id_trabajador');
    }
    public function historial_trabajos()
    {
        return $this->hasMany('Varmetal\TrabajosAyudante', 'ayudante_id_ayudante');
    }
}
