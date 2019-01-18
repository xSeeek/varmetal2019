@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Piezas</div>
                    <div class="card=body container mt-3">
                        @if(($productos != NULL) && (count($productos) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Peso Total(Kg)</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $key => $producto)
                                <tr id="id_producto{{ $producto->idProducto }}">
                                    <td scope="col">{{ $producto->codigo }}</td>
                                    @switch($producto->prioridad)
                                        @case(1)
                                            <td scope="col">Baja</td>
                                            @break
                                        @case(2)
                                            <td scope="col">Media Baja</td>
                                            @break
                                        @case(3)
                                            <td scope="col">Media</td>
                                            @break
                                        @case(4)
                                            <td scope="col">Media Alta</td>
                                            @break
                                        @case(5)
                                            <td scope="col">Alta</td>
                                            @break
                                        @default
                                            <td scope="col">Sin prioridad</td>
                                            @break
                                    @endswitch
                                    @switch($producto->estado)
                                        @case(0)
                                            <td scope="col">Por realizar</th>
                                            @break
                                        @case(1)
                                            @if($producto->terminado == true)
                                                <td scope="col">Finalizado</td>
                                            @else
                                                <td scope="col">Pendiente de revisión</td>
                                            @endif
                                            @break
                                        @case(2)
                                            <td scope="col">En realización</th>
                                            @break
                                        @default
                                            <td scope="col">Sin estado definido</th>
                                            @break
                                    @endswitch
                                    <td scope="col">{{ $producto->cantProducto }}</td>
                                    <td scope="col">{{ $producto->pesoKg * $producto->cantProducto }}</td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('productoControl', [$producto->idProducto])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No existen Piezas registrados en el sistema</h4>
                        <br>
                        @endif
                    </div>
                <br>
                <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addProducto')}}"><b>Agregar Piezas</b></a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
@endsection
