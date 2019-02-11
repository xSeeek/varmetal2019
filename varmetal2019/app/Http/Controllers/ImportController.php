<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Http\Requests\CsvImportRequest;
use Carbon\Carbon;
use Varmetal\CSVData;
use Varmetal\Obra;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->has('header'))
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        else
            $data = array_map('str_getcsv', file($path));

        if (count($data) > 0)
        {
            if ($request->has('header'))
            {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value)
                    $csv_header_fields[] = $key;
            }
            $csv_data = array_slice($data, 0, count($data));

            $csv_data_file = CSVData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data),
                'csv_table' => $request->table,
            ]);
        }
        else
            return redirect()->back();

        return view('admin.import.import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));
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
        $data_csv = CsvData::find($request->csv_data_file_id);
        foreach ($data as $row)
        {
            $obra = new Obra();
            foreach (config('app.db_obras') as $index => $field)
            {
                if ($data_csv->csv_header)
                    $obra->$field = $row[$request->fields[$field]];
                else
                    $obra->$field = $row[$request->fields[$index]];
            }
            if((Obra::where('codigo', $obra->codigo)->first()) != NULL)
                continue;
            if($obra->fechaInicio = 'No determinada')
                $obra->fechaInicio = (new Carbon())->now();
            else
                $obra->fechaInicio = Carbon::parse($obra->fechaInicio);
            $obra->save();
        }
        return;
    }

    private function file_post_contents($url, $data)
    {
        $postdata = http_build_query($data);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                . "X-CSRF-TOKEN: " . csrf_token() . "\r\n",
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }

    /*$data = array("rut" => "11.111.112-K");
    var_dump($this->file_post_contents('http://gestion.varmetal.cl/asistencia/obtenerAsistencia', $data));
    return;*/
}
