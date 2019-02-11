@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importar CSV</div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                        <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                            <label for="csv_file" class="col-md-4 control-label"><b>CSV a importar:</b></label>
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <input id="csv_file" type="file" class="form-control-file" name="csv_file" onchange="checkfile(this);" required>

                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('csv_file') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="header" checked> ¿CSV contiene los nombres de las columnas?
                                        <input class="form-check-input" name="table" value = "{{$table}}" hidden>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Continuar selección
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </br>
        </div>
    </div>
</br>
<div class="row justify-content-center">
        <a class="btn btn-primary btn-lg" role="button" href="{{url('/admin')}}"><b>Volver</b></a>
</div>
</div>
<script type="text/javascript" language="javascript">
    function checkfile(sender) {
        var validExts = new Array(".csv");
        var fileExt = sender.value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if (validExts.indexOf(fileExt) < 0) {
          showMensajeSwal(MSG_INFO, 'OK', COLOR_INFO,"Tipo de archivo no válido, solo se aceptan archivos " +
                   validExts.toString());
          return false;
        }
        else return true;
    }
</script>
@endsection
