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
                        <b>Descripcion:</b>
                        <div class="col-sm-10">
                          <input type="text" readonly id="descripcion" class="form-control-plaintext" value="{{$pausa->descripcion}}">
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
                      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="updateFechaFin({{$pausa->idPausa}})">Finalizar</a>
                    @else
                      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="alert('Pausa ya finalizada. No editable')">Finalizar</a>
                    @endif
                    <br><br>
                    <a class="btn btn-outline-success btn-md" id="detallesTrabajador" role="button" href="{{url('/trabajadorControl', [$trabajador->idTrabajador])}}">Trabajador</a>
                    <br><br>
                    <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="{{url('/productoControl', [$producto->idProducto])}}">Producto</a>
                </h6>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('/adminPausas')}}"><b>Volver</b></a>
    </div>
</div>
<script>
  function updateFechaFin(data)
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
  }
</script>
@endsection
