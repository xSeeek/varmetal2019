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
                <table id="tablaCursosAlumno" style="width:90%; margin:20px;">
                    <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                    </tr>
                    @foreach($trabajadores as $key => $trabajador)
                    <tr id="id_Trabajador{{ $trabajador->idTrabajador }}">
                        <td scope="col">{{ $trabajador->rut }}</td>
                        <td scope="col">{{ $trabajador->nombre }}</td>
                        <td scope="col">{{ $trabajador->cargo }}</td>
                        <td scope="col"><a class="btn btn-secondary btn-sm" role="button" onclick="{{url('detalleTrabajador', [$trabajador->idTrabajador])}}"><b>Eliminar</b></a>
                    </tr>
                    @endforeach
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
                    <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="{{url('pausa.addPausa', [$producto->idProducto])}}">Pausar</a>
                </h6>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminProducto')}}"><b>Volver</b></a>
    </div>
</div>
@endsection
