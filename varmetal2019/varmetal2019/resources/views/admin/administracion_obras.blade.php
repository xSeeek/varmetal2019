@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Listado de Productos</div>
                    <div class="card=body container mt-3">
                        @if(($obras != NULL) && (count($obras) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Proyecto</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $key => $obra)
                                <tr id="id_obra{{ $obra->idObra }}">
                                    <td scope="col">{{ $obra->nombre }}</td>
                                    <td scope="col">{{ $obra->proyecto }}</td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('obraControl', [$obra->idObra])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No existen obras registrados en el sistema</h4>
                        <br>
                        @endif
                    </div>
                <br>
                @if(Auth::user()->isAdmin())
                    <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addObra')}}"><b>Agregar Obra</b></a>
                @endif
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
@endsection
