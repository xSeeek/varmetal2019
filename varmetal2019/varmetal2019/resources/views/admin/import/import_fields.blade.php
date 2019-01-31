@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Configuración de importación de CSV</div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->idCSV }}" />
                        <input type="hidden" name="csv_table" value="{{ $csv_data_file->csv_table }}" />

                        <table class="table">
                            @if (isset($csv_header_fields))
                                <tr>
                                    @foreach ($csv_header_fields as $csv_header_field)
                                        <th>{{ $csv_header_field }}</th>
                                    @endforeach
                                </tr>
                            @endif
                            @foreach ($csv_data as $row)
                                <tr>
                                @foreach ($row as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                @foreach ($csv_data[0] as $key => $value)
                                    <td>
                                        <select name="fields[{{ $key }}]">
                                            @foreach (config('app.db_obras') as $db_field)
                                                <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                    @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-success">
                            Importar datos
                        </button>
                    </form>
                </div>
            </div>
            </br>
        </div>
    </div>
</br>
<div class="row justify-content-center">
        <a class="btn btn-primary btn-lg" role="button" href="{{url('/import', [$csv_data_file->csv_table])}}"><b>Volver</b></a>
</div>
</div>
@endsection
