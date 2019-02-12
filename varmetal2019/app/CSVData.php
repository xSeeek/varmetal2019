<?php

namespace Varmetal;

use Illuminate\Database\Eloquent\Model;

class CSVData extends Model
{
    public $primaryKey = 'idCSV';
    protected $table = 'csv_data';
    protected $fillable = ['csv_filename', 'csv_header', 'csv_data', 'csv_table'];

    const OT_TABLE = 'OT';
    const PIEZA_TABLE = 'Pieza';
    const TRABAJADOR_TABLE = 'Trabajador';
}
