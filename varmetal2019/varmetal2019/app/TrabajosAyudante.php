<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class TrabajosAyudante extends Model
{
    public function trabajos_ayudante()
    {
        return $this->belongsToMany('Varmetal\Ayudante', 'trabajos_ayudantes', 'historial_id_historial', 'ayudante_id_ayudante');
    }
}
