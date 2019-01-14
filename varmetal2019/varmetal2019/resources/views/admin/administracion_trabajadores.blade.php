@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajadores</div>
                    <div class="card=body container mt-3">
                        @if(($trabajadores_almacenados != NULL) && (count($trabajadores_almacenados) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trabajadores_almacenados as $key => $trabajador)
                                <tr id="id_trabajador{{ $trabajador->idTrabajador }}">
                                    <td scope="col">{{ $trabajador->rut }}</td>
                                    <td scope="col">{{ $trabajador->nombre }}</td>
                                    @if($trabajador->estado == 1)
                                        <td scope="col">Activo</td>
                                    @else
                                        <td scope="col">Inactivo</td>
                                    @endif
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('trabajadorControl', [$trabajador->idTrabajador])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay trabajadores registrados en el sistema</h4>
                        <br>
                        @endif
                    </div>
                    </br>
                @if(Auth::user()->isAdmin())
                    <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addTrabajador')}}"><b>Agregar Trabajador</b></a>
                @endif
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuTrabajador')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
@endsection
