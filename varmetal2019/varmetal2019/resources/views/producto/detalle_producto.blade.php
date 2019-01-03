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
                            <input type="text" readonly id="nombreTrabajador" class="form-control-plaintext" value="{{$producto->nombre}}">
                        </div>
                        <b>Fecha de Inicio de Desarrollo:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="{{$producto->fechaInicio}}">
                        </div>
                        <b>Fecha de Finalización de Desarrollo:</b>
                        <div class="col-sm-10">
                            @if($producto->fechaFin == NULL)
                                <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Aún no se finaliza">
                            @else
                                <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="{{$producto->fechaFin}}">
                            @endif
                        </div>
                        <b>Peso (en Kilogramos):</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="{{$producto->pesoKg}} Kg">
                        </div>
                        <b>Estado Actual:</b>
                        <div class="col-sm-10">
                            @switch($producto->estado)
                                @case(0)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Por realizar">
                                    @break
                                @case(1)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Finalizado">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="En realización">
                                    @break
                                @default
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Sin estado definido">
                                    @break
                            @endswitch
                        </div>
                        <b>Prioridad:</b>
                        <div class="col-sm-10">
                            @switch($producto->prioridad)
                                @case(1)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Baja">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Media Baja">
                                    @break
                                @case(3)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Media">
                                    @break
                                @case(4)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Media Alta">
                                    @break
                                @case(5)
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Alta">
                                    @break
                                @default
                                    <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="Sin prioridad">
                                    @break
                            @endswitch
                        </div>
                    </h5>
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
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminTrabajador')}}"><b>Volver</b></a>
    </div>
</div>
@endsection
