<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class TrabajosAyudante extends Model
{
    public $primaryKey = 'idHistorial';
    protected $table = 'historial_trabajos';

    public function trabajos_ayudante()
    {
        return $this->belongsTo('Varmetal\Ayudante', 'ayudante_id_ayudante');
    }
}
