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
                    Detalle de la Pieza
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Código de la Pieza:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="codigoProducto" class="form-control-plaintext" value="{{$producto->codigo}}">
                        </div>
                        <b>Nombre del Pieza:</b>
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
                        <b>Peso unitario(en Kilogramos):</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="pesoProducto" class="form-control-plaintext" value="{{$producto->pesoKg}} Kg">
                        </div>
                        <b>OT a la que pertenece:</b>
                        <div class="col-sm-10">
                            @if($obra != null)
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="{{$obra->nombre}}">
                            @else
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="No asignada">
                            @endif
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
                        @if($producto->estado == 1 && $producto->terminado == false)
                            <br>
                            <b style="color:red">Información Importante:</b>
                            <div class="col-sm-10">
                                <input type="text" readonly id="pesoProducto" style="color:red" class="form-control-plaintext" value="Este producto se marcó como terminado.">
                            </div>
                        @endif
                        <b>Tiempo en Pausa:</b>
                        <div class="col-sm-10">
                            @if($producto->tiempoEnPausa != NULL)
                              @if($producto->tiempoEnPausa/60 < 1)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->tiempoEnPausa}} Minutos">
                              @else
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->tiempoEnPausa/60}} Horas">
                              @endif
                            @else
                            <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="No se han solicitado Pausas">
                            @endif
                        </div>
                        <b>Tiempo en SetUp:</b>
                        <div class="col-sm-10">
                            @if($producto->tiempoEnSetUp != NULL)
                              @if($producto->tiempoEnSetUp/60 < 1)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->tiempoEnSetUp}} Minutos">
                              @else
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->tiempoEnSetUp/60}} Horas">
                              @endif
                            @else
                              <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="No se han producido cambios de pieza">
                            @endif
                        </div>
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Operadores activos</div>
                <div class="card-body">

                @if(($trabajadores != NULL) && (count($trabajadores)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Kg realizados</th>
                            <th>Estado</th>
                            <th>Ficha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajadores as $key => $trabajador)
                        <tr id="id_Trabajador{{ $trabajador->idTrabajador }}">
                            <td scope="col">{{ $trabajador->rut }}</td>
                            <td scope="col">{{ $trabajador->nombre }}</td>
                            <td scope="col">{{ $trabajador->cargo }}</td>
                            <td scope="col">{{ $trabajador->pivot->kilosTrabajados }}</td>
                            @if($trabajador->pivot->fechaComienzo == NULL)
                                <td scope="col">Aún no inicia</td>
                            @else
                                <td scope="col">Inició el desarrollo</td>
                            @endif
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" href="{{url('trabajadorControl', [$trabajador->idTrabajador])}}" role="button"><b>Ficha Trabajador</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteWorker({{ $trabajador->idTrabajador }}, {{ $producto->idProducto }})" role="button"><b>Eliminar</b></a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">No hay Operadores asignados.</h4>
                </br>
                @endif
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminProducto')}}"><b>Volver</b></a>
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
                <h5>
                    Ver Pausas:
                </br>
                    <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="{{url('adminPausasAlmacenadas', [$producto->idProducto])}}">Pausas</a>
                </h5>
                <br>
                <h5>
                    Eliminar Pieza:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteProducto({{$producto->idProducto}})">Eliminar</a>
                </h5>
                <br>
                @if($obra == NULL)
                <h5>
                    Asignar OT:
                </br>
                    <a class="btn btn-outline-danger btn-md" id="asignarButton" role="button" href="{{url('producto/asignarObra', [$producto->idProducto])}}">Asignar</a>
                </h5>
                <br>
                @endif
                <h5>
                    Asignar más Operadores:
                </br>
                    @if($obra != NULL)
                        <a class="btn btn-outline-success btn-md" id="insertButton" role="button" href="{{url('producto/asignarTrabajo', [$producto->idProducto])}}">Asignar</a>
                    @else
                        <a class="btn btn-outline-success btn-md" id="insertButton" role="button" disabled>Debe asignar el producto a un OT primero</a>
                    @endif
                </h5>
                @if($producto->terminado == false)
                    @if($producto->estado == 1)
                        <br>
                        <h5>
                            Anular Termino:
                        </br>
                            <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProduccion({{$producto->idProducto}})">Reiniciar</a>
                        </h5>
                        <br>
                        <h5>
                            Terminar Pieza:
                        </br>
                            <a class="btn btn-outline-danger btn-md" id="finishButton" role="button" onclick="finishProduccion({{$producto->idProducto}})">Terminar</a>
                        </h5>
                    @endif
                @else
                    <br>
                    <h5>
                        Reiniciar Pieza:
                    </br>
                        <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProducto({{$producto->idProducto}})">Reiniciar</a>
                    </h5>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteProducto(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('/productoControl/deleteProducto')}}",
            success: function(response){
                window.location.href = response.redirect;
            }
        });
    }
    function deleteWorker(idTrabajador, idProducto)
    {
        var data, json_data;

        data = Array();
        data[0] = idTrabajador;
        data[1] = idProducto;

        json_data = JSON.stringify(data);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/productoControl/removeWorker')}}",
            success: function(response){
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
    function resetProduccion(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/resetProduccion')}}",
            success: function(response){
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
    function finishProduccion(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/finishProduccion')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
                else
                    showMensajeSwall(MSG_ERROR, response);
            }
        });
    }
    function resetProducto(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/resetProducto')}}",
            success: function(response){
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
</script>
@endsection
