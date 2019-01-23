@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ayudantes</div>
                    <div class="card=body container mt-3">
                        @if(($ayudantes_almacenados != NULL) && (count($ayudantes_almacenados) > 0))
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
                                @foreach($ayudantes_almacenados as $key => $ayudante)
                                <tr id="id_trabajador{{ $ayudante->idAyudante }}">
                                    <td scope="col">{{ $ayudante->rut }}</td>
                                    <td scope="col">{{ $ayudante->nombre }}</td>
                                    @if($ayudante->lider_id_trabajador != NULL)
                                        <td scope="col">Asignado</td>
                                    @else
                                        <td scope="col">No Asignado</td>
                                    @endif
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('trabajadorControl', [$ayudante->idAyudante])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay ayudantes registrados en el sistema</h4>
                        <br>
                        @endif
                    </div>
                @if(Auth::user()->isAdmin())
                    <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addAyudante')}}"><b>Agregar Ayudantes</b></a>
                @endif
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuTrabajador')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
@endsection
