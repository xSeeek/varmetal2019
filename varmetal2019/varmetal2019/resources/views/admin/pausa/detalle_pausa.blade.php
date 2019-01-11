@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalle de la Pausa</div>
                <div class="card-body">
                    <h5>
                        <b>ID de la Pausa:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="idPausa" class="form-control-plaintext" value="{{$pausa->idPausa}}" readonly="readonly">
                        </div>
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
                        <b>Nombre del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$producto->nombre}}" readonly="readonly">
                        </div>
                        <b>Nombre del Trabajador:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreTrabajador" class="form-control-plaintext" value="{{$trabajador->nombre}}">
                        </div>
                        @if($pausa->fechaFin == NULL)
                          <b>Descripcion: (Editable)</b>
                        @else
                          <b>Descripcion:</b>
                        @endif
                        <div class="col-sm-10">
                          @if($pausa->fechaFin == NULL)
                            <input type="text" id="descripcion" class="form-control-plaintext" value="{{$pausa->descripcion}}">
                          @else
                            <input type="text" readonly id="descripcion" class="form-control-plaintext" value="{{$pausa->descripcion}}">
                          @endif
                        </div>
                    </h5>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Opciones</div>
            <div class="card-body" align='center'>
                <h6>
                    @if($pausa->fechaFin==NULL)
                        @if($usuarioActual->type == 'Admin')
                          <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="adminUpdateFechaFin({{$pausa->idPausa}})">Finalizar</a>
                          <br><br>
                          <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="adminDeletePausa({{$pausa->idPausa}})">Eliminar</a>

                        @else
                            <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="trabajadorUpdateFechaFin()">Finalizar</a>
                            <br><br>
                            <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="trabajadorDeletePausa({{$pausa->idPausa}})">Eliminar</a>
                        @endif
                    @else
                        <b>Pausa Finalizada</b>
                    @endif
                    <br><hr>
                    @if($usuarioActual->type == 'Admin')
                      <a class="btn btn-outline-success btn-md" id="detallesTrabajador" role="button" href="{{url('/trabajadorControl', [$trabajador->idTrabajador])}}">Trabajador</a>
                      <br><br>
                      <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="{{url('/productoControl', [$producto->idProducto])}}">Producto</a>
                      <br><br>
                    @else
                      <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="{{url('/detalleProducto', [$producto->idProducto])}}">Producto</a>
                      <br><br>
                    @endif
                </h6>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            @if($usuarioActual->type=='Admin')
              <a class="btn btn-primary btn-lg" role="button" href="{{url('/adminPausas')}}"><b>Volver</b></a>
            @else
              <a class="btn btn-primary btn-lg" role="button" href="{{url('addPausa', [$producto->idProducto])}}"><b>Volver</b></a>
            @endif
    </div>
</div>
<script>
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
              window.location.href = "{{url('/addPausa', [$producto->idProducto])}}";
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

  function adminUpdateFechaFin(data)
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
              window.location.href = "{{url('/addPausa', [$pausa->idPausa])}}";
          }
      });
  }
  function trabajadorUpdateFechaFin()
  {

    var datosPausa, json_text;

    datosPausa = Array();
    datosPausa[0] = {{$pausa->idPausa}};
    datosPausa[1] = document.getElementById("descripcion").value;
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
  }
</script>
@endsection
