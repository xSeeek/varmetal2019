@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nombre del Producto: {{$producto->nombre}}</div>
                <div class="card=body">
                  <label for="fechaInicio" id="fechaInicio">Fecha Inicio: {{$fechaInicio}}</label>
                  <br>Descripción</br>
                    <div>
                      <textarea id="detalle" aria-label="Crear Pausa"></textarea>
                    </div>
                  <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa()"><b>Terminar Pausa</b></a>
                  <a class="btn btn-outline-success my-2 my-sm-0" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}"><b>Volver</b></a>
                </div>
            </div>
          </div>
        </div>
  </div>
<script type="text/javascript">
function savePausa()
    {
        var datosPausa, json_text;

        datosPausa = Array();
        datosPausa[0] = {{$producto->idProducto}};
        datosPausa[1] = document.getElementById("detalle").value;
        datosPausa[2] = 'weaInicio';
        datosPausa[4] = 'weafin';
        alert('Producto: '+datosPausa[0]+
        ' - descripcion: '+datosPausa[1]+
        ' - fechaInicio: '+datosPausa[2]+
        ' - fechaFin   : '+datosPausa[4]);

        json_text = JSON.stringify(datosPausa);
        alert('pasando de too');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('/pausaControl/addPausa')}}",
            success: function(response){
                if(response!=1)
                {
                    alert('sorry compare');
                    console.log(response);
                }
                else
                    alert('wena compare');
                    window.location.href="{{url('/detalleProducto', [$producto->idProducto])}}";
            }
        });
    }
</script>
@endsection
