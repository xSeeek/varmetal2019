<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    public $primaryKey = 'idTipo';
    protected $table = 'tipo';

    public function producto()
    {
        return $this->hasMany('Varmetal\Producto', 'tipo_id_tipo');
    }
}
