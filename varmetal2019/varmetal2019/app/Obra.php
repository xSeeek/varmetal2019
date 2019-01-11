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
}
