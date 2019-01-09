@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalle del producto</div>
                <div class="card-body">
                    <h5>
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
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="En realización">
                                    @break
                                @default
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Sin estado definido">
                                    @break
                            @endswitch
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
                            <th>Cargo</th>
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
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" href="{{url('trabajadorControl', [$trabajador->idTrabajador])}}" role="button"><b>Ficha Trabajador</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteWorker({{ $trabajador->idTrabajador }}, {{ $producto->idProducto }})" role="button"><b>Eliminar</b></a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">No hay trabajadores asignados.</h4>
                </br>
                @endif
                </div>
        </div>
        </div>
        <div class="card">
            <div class="card-header">Opciones de Administración</div>
            <div class="card-body" align='center'>
                <h6>
                    Solicitar Pausa:
                </br>
                    <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="{{url('addPausa', [$producto->idProducto])}}">Pausar</a>
                </h6>
                <br>
                <h6>
                    Eliminar Producto:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteProducto({{$producto->idProducto}})">Eliminar</a>
                </h6>
                <br>
                <h6>
                    Asignar más trabajadores:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" href="{{url('producto/asignarTrabajo', [$producto->idProducto])}}">Asignar</a>
                </h6>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminProducto')}}"><b>Volver</b></a>
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
                console.log(response);
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
                console.log('asd');
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
    window.onload = function formatTable()
    {
        var table = $('#tablaAdministracion').DataTable({
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "scrollX": true,
       });
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
       });
    }
</script>
@endsection
