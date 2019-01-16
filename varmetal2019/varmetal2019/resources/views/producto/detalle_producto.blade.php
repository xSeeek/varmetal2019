@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalle del pieza
                </div>
                <div class="card-body">
                    <h5>
                        <b>Cantidad realizada:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="cantidadProducto" class="form-control-plaintext" value="{{$cantidadProducida}}/{{$producto->cantProducto}}">
                        </div>
                        <b>Prioridad:</b>
                        <div class="col-sm-10">
                            @switch($producto->prioridad)
                                @case(1)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Baja">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Baja">
                                    @break
                                @case(3)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media">
                                    @break
                                @case(4)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Alta">
                                    @break
                                @case(5)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Alta">
                                    @break
                                @default
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Sin prioridad">
                                    @break
                            @endswitch
                        </div>
                        <b>Solicitar Pausa:</b>
                        <div class="col-sm-10">
                          @if($producto->fechaFin == NULL)
                            <br>
                            <a class="btn btn-outline-success btn-lg" id="pauseButton" role="button" href="{{url('addPausa', [$producto->idProducto])}}">Pausar</a>
                          @endif
                        </div>
                        <div class="col-sm-10">
                          @if($producto->terminado == false)
                              @if($producto->estado == 2)
                                  @if($cantidadProducida == $producto->cantProducto)
                                      <h5>
                                      <br>
                                          Marcar como terminado:
                                      <br>
                                      <br>
                                          <a class="btn btn-warning btn-lg" id="stopButton" role="button" onclick="sendEmail()">Terminar</a>
                                      </h5>
                                  @endif
                              @else
                                  <br>
                                  <h5>
                                      Anular termino:
                                  <br>
                                      <a class="btn btn-outline-danger btn-lg" id="stopButton" role="button" onclick="unmarkAsFinished({{$producto->idProducto}})">Anular</a>
                                  </h5>
                              @endif
                          @endif
                        </div>
                    </h5>
                </div>
                @if($cantidadProducida != $producto->cantProducto)
                    @if(($cantidadProducida+'1')%'5'==0)
                    <a class="btn btn-outline-primary btn-lg" role="button" onclick="sendEmailProductos()"><b>Actualizar cantidad producida</b></a>
                    @else
                    <a class="btn btn-outline-primary btn-lg" role="button" onclick="actualizarCantidad({{$producto->idProducto}})"><b>Actualizar cantidad producida</b></a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('/productosTrabajador')}}"><b>Volver</b></a>
    </div>
</div>
<script type="text/javascript">

function sendEmailProductos()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = '{{$trabajador->nombre}}';
      datosPausa[1] = '{{$trabajador->rut}}';
      datosPausa[2] = '{{$usuarioActual->email}}';
      datosPausa[3] = '{{$producto->nombre}}';
      datosPausa[4] = '{{$producto->codigo}}';
      datosPausa[5] = '{{$cantidadProducida}}';
      json_text = JSON.stringify(datosPausa);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('/enviarEmailProducto')}}",
            success: function(response){
                if(response!='Email enviado producto')
                {
                    alert(response);
                    console.log(response);
                }
                else
                    actualizarCantidad({{$producto->idProducto}});
          }
        });
    }

function sendEmail()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = '{{$trabajador->nombre}}';
      datosPausa[1] = '{{$trabajador->rut}}';
      datosPausa[2] = '{{$usuarioActual->email}}';
      datosPausa[3] = '{{$producto->nombre}}';
      datosPausa[4] = '{{$producto->codigo}}';
      json_text = JSON.stringify(datosPausa);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('/enviarEmailTerminado')}}",
            success: function(response){
                if(response!='Email enviado producto Terminado')
                {
                    alert(response);
                    console.log(response);
                }
                else
                    markAsFinished({{$producto->idProducto}});
          }
        });
    }

    function markAsFinished(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('producto/Finalizar')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('/detalleProducto', [$producto->idProducto])}}";
                else {
                    alert(response);
                }
            }
        });
    }
    function unmarkAsFinished(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('producto/Anular')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('/detalleProducto', [$producto->idProducto])}}";
                else {
                        alert(response);
                    }
            }
        });
    }
    function actualizarCantidad(idProducto)
    {
        if (confirm("Presione OK para actualizar la cantidad"))
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {DATA:idProducto},
                url: "{{url('producto/actualizarCantidad')}}",
                success: function(response){
                    if(response == 1)
                        window.location.href = "{{url('/detalleProducto', [$producto->idProducto])}}";
                    else {
                            alert(response);
                        }
                    }
                });
            }
        else
            return;
    }
</script>
@endsection
