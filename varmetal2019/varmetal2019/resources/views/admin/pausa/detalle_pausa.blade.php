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
                  Detalle de la Pausa
                  @if(Auth::user()->type!='Trabajador')
                  <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                  @endif
                </div>
                <div class="card-body">
                    <h5>
                        <b>Fecha de Inicio:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicioPausa" class="form-control-plaintext" value="{{$pausa->fechaInicio}}" readonly="readonly">
                        </div>
                        <b>Fecha de Finalización:</b>
                        <div class="col-sm-10">
                            @if($pausa->fechaFin == NULL)
                                <input type="text" readonly id="fechaFinPausa" class="form-control-plaintext" value="Pausa pendiente">
                            @else
                                <input type="text" readonly id="fechaFinPausa" class="form-control-plaintext" value="{{$pausa->fechaFin}}" readonly="readonly">
                            @endif
                        </div>
                        @if(Auth::user()->type!='Trabajador')
                          <b>Nombre de la Pieza:</b>
                          <div class="col-sm-10">
                              <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$producto->nombre}}" readonly="readonly">
                          </div>

                          <b>ID de la Pieza:</b>
                          <div class="col-sm-10">
                              <input type="text" readonly id="codigo" class="form-control-plaintext" value="{{$producto->codigo}}" readonly="readonly">
                          </div>
                          <b>Nombre del Operador:</b>
                          <div class="col-sm-10">
                              <input type="text" readonly id="nombreTrabajador" class="form-control-plaintext" value="{{$trabajador->nombre}}">
                          </div>
                        @endif
                        <b>Motivo de la Pausa:</b>
                        <div class="col-sm-10">
                          @if($pausa->motivo!=NULL)
                            <input type="text" readonly id="motivo" class="form-control-plaintext" value="{{$pausa->motivo}}">
                          @else
                            <input type="text" readonly id="motivo" class="form-control-plaintext" value="No se pudo especificar el motivo (Leer la descripción)">
                          @endif
                        </div>
                        @if($pausa->fechaFin == NULL)
                          <b>Descripcion:</b>
                        @else
                          <b>Descripcion:</b>
                        @endif
                        <div class="col-sm-10">
                          @if($pausa->fechaFin == NULL)
                            <input type="text" readonly id="descripcion" class="form-control-plaintext" value="{{$pausa->descripcion}}">
                          @else
                            <input type="text" readonly id="descripcion" class="form-control-plaintext" value="{{$pausa->descripcion}}">
                          @endif
                        </div>
                    </h5>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="Opciones disponibles" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Opciones Disponibles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" align="center">
                <h5>
                    @if($pausa->fechaFin==NULL)
                        @if($usuarioActual->type != 'Trabajador')
                          <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="adminUpdateFechaFin()">Finalizar Pausa</a>
                        @endif
                    @else
                        <b>Pausa Finalizada</b>
                    @endif
                    <hr>
                    @if($usuarioActual->type != 'Trabajador')
                      <a class="btn btn-outline-success btn-md" id="detallesTrabajador" role="button" href="{{url('/trabajadorControl', [$trabajador->idTrabajador])}}">Ver Trabajador</a>
                      <br><br>
                      <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="{{url('/productoControl', [$producto->idProducto])}}">Ver Producto</a>
                      <br><br>
                    @endif
                </h5>
            </div>
        </div>
    </div>
  </div>
</div>
  </br>
  <div class="row justify-content-center">
    @if(Auth::user()->type == 'Trabajador' && $pausa->fechaFin == NULL)
      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="trabajadorDeletePausa({{$pausa->idPausa}})">Eliminar Pausa</a>
    @else
      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="adminDeletePausa({{$pausa->idPausa}})">Eliminar Pausa</a>
    @endif
  </div>
</div>
    </br>
    <div class="row justify-content-center">
            @if($usuarioActual->type!='Trabajador')
              <a class="btn btn-primary btn-lg" role="button" href="{{url('/adminPausas')}}"><b>Volver</b></a>
            @else
              <a class="btn btn-primary btn-lg" role="button" href="{{url('addPausa', [$producto->idProducto])}}"><b>Volver</b></a>
            @endif
    </div>
</div>
<script>

  function sendEmail()
  {

    var datos,json_text;

    datos = Array();
    datos[0] = '{{$trabajador->nombre}}';
    datos[1] = '{{$trabajador->rut}}';
    datos[2] = '{{$trabajador->user->email}}';
    datos[3] = '{{$producto->codigo}}';
    datos[4] = '{{$producto->nombre}}';

    json_text = JSON.stringify(datos);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_text},
        url: "{{url('/emailPausaEliminada')}}",
        success: function(response){
            if(response!='Email enviado registrado')
                showMensajeSwall(MSG_ERROR, response);
            else
              window.location.href = "{{url('/addPausa', [$producto->idProducto])}}";

      }
    });
  }

  function trabajadorDeletePausa()
  {
    var datos, json_text;

    datos = Array();
    datos[0] = {{$pausa->idPausa}};
    datos[1] = {{$producto->idProducto}};
    json_text = JSON.stringify(datos);

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/trabajadorDeletePausa')}}",
          success: function(response){
              console.log(response);
              sendEmail();
          }
      });
  }
  function adminDeletePausa(data)
  {
    var datos, json_text;

    datos = Array();
    datos[0] = {{$pausa->idPausa}};
    datos[1] = {{$producto->idProducto}};
    json_text = JSON.stringify(datos);

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/adminDeletePausa')}}",
          success: function(response){
              console.log(response);
              window.location.href = "{{url('/adminPausasAlmacenadas', [$producto->idProducto])}}";
          }
      });
  }

  /*function adminUpdateFechaFin(data)
  {
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:data},
          url: "{{url('/adminUpdateFechaFinPost')}}",
          success: function(response){
              console.log(response);
              window.location.href = "{{url('/adminDetallesPausaGet', [$pausa->idPausa])}}";
          }
      });
  }*/



    /*function trabajadorUpdateFechaFin()
      {
        var datosPausa, json_text;

        datosPausa = Array();
        datosPausa[0] = '{{$pausa->idPausa}}';
        datosPausa[1] = document.getElementById("descripcion").value;
        datosPausa[2] = document.getElementById("motivo").value;
        datosPausa[3] = '{{$producto->obras_id_obra}}';
        json_text = JSON.stringify(datosPausa);
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              data: {DATA:json_text},
              url: "{{url('trabajadorUpdateFechaFinPost')}}",
              success: function(response){
                  console.log(response);
                  window.location.href = "{{url('/trabajadorDetallesPausaGet', [$pausa->idPausa])}}";
              }
          });
      }*/
      function adminUpdateFechaFin()
        {
          var datosPausa, json_text;

          datosPausa = Array();
          datosPausa[0] = '{{$pausa->idPausa}}';
          datosPausa[1] = '{{$trabajador->idTrabajador}}';
          datosPausa[2] = document.getElementById("motivo").value;
          datosPausa[3] = '{{$producto->obras_id_obra}}';
          json_text = JSON.stringify(datosPausa);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {DATA:json_text},
                url: "{{url('adminUpdateFechaFinPost')}}",
                success: function(response){
                    console.log(response);
                    window.location.href = "{{url('/adminDetallesPausaGet', [$pausa->idPausa])}}";
                }
            });
        }
</script>
@endsection
