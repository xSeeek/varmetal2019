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
                    Detalle del producto
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Código del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="codigoProducto" class="form-control-plaintext" value="{{$producto->codigo}}">
                        </div>
                        <b>Nombre del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$producto->nombre}}">
                        </div>
                        <b>Fecha de Inicio de Desarrollo:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->fechaInicio}}">
                        </div>
                        <b>Fecha de Finalización de Desarrollo:</b>
                        <div class="col-sm-10">
                            @if($producto->fechaFin == NULL)
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Aún no se finaliza">
                            @else
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="{{$producto->fechaFin}}">
                            @endif
                        </div>
                        <b>Peso (en Kilogramos):</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="pesoProducto" class="form-control-plaintext" value="{{$producto->pesoKg}} Kg">
                        </div>
                        <b>Obra:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="{{$producto->obra}}">
                        </div>
                        <b>Estado Actual:</b>
                        <div class="col-sm-10">
                            @switch($producto->estado)
                                @case(0)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Por realizar">
                                    @break
                                @case(1)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Finalizado">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="En proceso de desarrollo">
                                    @break
                                @default
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Sin estado definido">
                                    @break
                            @endswitch
                        </div>
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
                    </h5>
                </div>
                @if($cantidadProducida != $producto->cantProducto)
                    <a class="btn btn-outline-primary btn-lg" role="button" onclick="actualizarCantidad({{$producto->idProducto}})"><b>Actualizar cantidad producida</b></a>
                @endif
            </div>
            <br>
            <div class="card">
                <div class="card-header">Trabajadores activos</div>
                <div class="card-body">

                @if(($trabajadores != NULL) && (count($trabajadores)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajadores as $key => $trabajador)
                        <tr id="id_Trabajador{{ $trabajador->idTrabajador }}">
                            <td scope="col">{{ $trabajador->rut }}</td>
                            <td scope="col">{{ $trabajador->nombre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <br>
                    <h4 align="center">No hay trabajadores asignados.</h4>
                <br>
                @endif
                </div>
            </div>
        <br>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminTrabajador')}}"><b>Volver</b></a>
    </div>
</div>
<div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="Opciones disponibles" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opciones disponibles:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
              @if($producto->fechaFin == NULL)
                <h5>
                    Solicitar Pausa:
                <br>
                      <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="{{url('addPausa', [$producto->idProducto])}}">Pausar</a>
                </h5>
              @endif
                <br>
                @if($producto->terminado == false)
                    @if($producto->estado == 2)
                        @if($cantidadProducida == $producto->cantProducto)
                            <h5>
                                Marcar como terminado:
                            <br>
                                <a class="btn btn-outline-warning btn-md" id="stopButton" role="button" onclick="markAsFinished({{$producto->idProducto}})">Terminar</a>
                            </h5>
                        @endif
                    @else
                        <h5>
                            Anular termino:
                        <br>
                            <a class="btn btn-outline-danger btn-md" id="stopButton" role="button" onclick="unmarkAsFinished({{$producto->idProducto}})">Anular</a>
                        </h5>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
</script>
@endsection
