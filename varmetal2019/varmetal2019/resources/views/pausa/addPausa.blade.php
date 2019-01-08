@extends('layouts.app')

@section('head')
<title>PAUSA</title>
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$producto->nombre}}</div>
                <div class="card=body">
                  <label for="fechaInicio" id="fechaInicio" class="col-md-4 col-form-label text-md-right">{{ __('now()')}}</label>

                      <div class="input-group row">
                        <div class="input-group mb-3">
                        <textarea id="detalle" class="form-control" aria-label="Crear Pausa"></textarea>
                      </div>
                  </div>
                  <a class="btn btn-outline-success my-2 my-sm-0" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}" onclick="asignarPausa"><b>Fin</b></a>            </div>
                </div>
          </div>
          <a class="btn btn-outline-success my-2 my-sm-0" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}"><b>Volver</b></a>
        </div>
|  </div>
<script type="text/javascript">
function saveChanges()
    {
        var updatedCurso, json_text;

        updatedCurso = Array();
        updatedCurso[0] = {{$producto->idProducto}};
        updatedCurso[1] = document.getElementById("detalle").value;
        updatedCurso[2] = document.getElementById("fechaInicio").value;
        updatedCurso[3] = {{$trabajador->idTrabajador}};

        json_text = JSON.stringify(updatedCurso);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('pausa/addPausa')}}",
            success: function(msg){
                alert(msg);
            }
        });
        changeStatus();
        return;
    }
</script>
