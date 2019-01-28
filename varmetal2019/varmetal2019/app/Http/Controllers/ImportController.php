<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Http\Requests\CsvImportRequest;
use Carbon\Carbon;
use Varmetal\CSVData;
use Varmetal\Obra;

class ImportController extends Controller
{
    public function getImport($data)
    {
        if(($data == CSVData::PIEZA_TABLE) || ($data == CSVData::TRABAJADOR_TABLE) || ($data == CSVData::OT_TABLE))
        {
            return view('admin.import.import')
                ->with('table', $data);
        }
        return redirect()->route('admin');
    }
    public function parseImport(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $csv_data_file = CSVData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data),
            'csv_table' => $request->table,
        ]);

        $csv_data = array_slice($data, 0, count($data));
        return view('admin.import.import_fields', compact('csv_data', 'csv_data_file'));
    }
    public function processImport(Request $request)
    {
        $data = CSVData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);

        if($request->csv_table == CSVData::OT_TABLE)
            $this->importObras($csv_data, $request);

        return redirect()->route('admin');
    }

    public function importObras($data, $request)
    {
        foreach ($data as $row)
        {
            $obra = new Obra();
            foreach (config('app.db_obras') as $index => $field)
            {
                if((Obra::where('codigo', $request->fields[$index])->first()) != NULL)
                    break;
                $obra->$field = $row[$request->fields[$index]];
                if($field == 'fechaInicio')
                    $obra->$field = Carbon::parse($obra->$field);
            }
            if($obra->fechaInicio = 'No determinada')
                $obra->fechaInicio = (new Carbon())->now();
            else
                $obra->fechaInicio = Carbon::parse($obra->fechaInicio);
            $obra->save();
        }
        return;
    }
}
