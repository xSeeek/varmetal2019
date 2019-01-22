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
                        <br>
                        @if($producto->fechaFin == NULL)
                        <div class="col-sm-10">
                            <h5>
                                Ver Pausas:
                                <br>
                                    <a class="btn btn-outline-success btn-lg" id="pauseButton" role="button" href="{{url('addPausa', [$producto->idProducto])}}">Pausar</a>
                            </h5>
                        </div>
                        @endif
                        <div class="col-sm-10">
                          @if($producto->terminado == false)
                              @if($producto->estado == 2)
                                  @if($cantidadProducida == $producto->cantProducto)
                                      <h5>
                                      <br>
                                          Marcar como terminado:
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
                    <br><b>Ingrese la Cantidad de Productos:</b>
                    <input type="text" id="cantidadX" name="fname" size="10" style="font-family: Arial; font-size: 14pt; border: 2px solid #39c;">
                    <br><a class="btn btn-outline-primary btn-lg" role="button" onclick="nuevaCantidad()"><b>Añadir "x" cantidad</b></a>
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

  function nuevaCantidad()
  {
      var datos, json_text;

      datos = Array();
      datos[0] = document.getElementById('cantidadX').value;
      datos[1] = '{{$producto->idProducto}}';
      json_text = JSON.stringify(datos);
      if(datos[0]>{{$producto->cantProducto}})
      {
        alert("La cantidad no puede ser mayor que el total");
        return 2;
      }
      if((datos[0]+{{$cantidadProducida}})>5 && (datos[0]+{{$cantidadProducida}})<={{$producto->cantProducto}})
      {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('/producto/actualizarCantidadX')}}",
            success: function(response){
                if(response == 1)
                  sendEmailProductosX(datos[0]);
              }
            });
            return 1;
      }
      if((datos[0]+{{$cantidadProducida}})<5 && (datos[0]+{{$cantidadProducida}})<={{$producto->cantProducto}}){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              data: {DATA:json_text},
              url: "{{url('/producto/actualizarCantidadX')}}",
              success: function(response){
                  if(response == 1)
                    sendEmailProductosX(datos[0]);
                }
              });
              return;
      }
      alert("hola");
  }

  function sendEmailProductosX(datos)
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = '{{$trabajador->nombre}}';
      datosPausa[1] = '{{$trabajador->rut}}';
      datosPausa[2] = '{{$usuarioActual->email}}';
      datosPausa[3] = '{{$producto->nombre}}';
      datosPausa[4] = '{{$producto->codigo}}';
      datosPausa[5] = datos;
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
                    showMensajeSwall(MSG_ERROR, response);
                else
                window.location.href = "{{url('/detalleProducto', [$producto->idProducto])}}";
              }
        });
    }

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
                    showMensajeSwall(MSG_ERROR, response);
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
      datosPausa[2] = '{{$trabajador->user->email}}';
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
                    showMensajeSwall(MSG_ERROR, response);
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
                    showMensajeSwall(MSG_ERROR, response);
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
                else
                    showMensajeSwall(MSG_ERROR, response);
            }
        });
    }
    function actualizarCantidad(idProducto)
    {
        swal({
        title: "Confirmación",
        text: "Presione Si para confirmar la actualización:",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6A9944",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        cancelButtonColor: "#d71e1e",
        }).then((result) =>
        {
            if (result.value)
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
        });
    }
</script>
@endsection
