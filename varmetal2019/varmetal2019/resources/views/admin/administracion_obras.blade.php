@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Listado de OT</div>
                    <div class="card=body container mt-3">
                        @if(($obras != NULL) && (count($obras) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $key => $obra)
                                <tr id="id_obra{{ $obra->idObra }}">
                                    <td scope="col">{{ $obra->codigo }}</td>
                                    <td scope="col">{{ $obra->proyecto }}</td>
                                    @if(count($obra->producto) != 0 && $obra->terminado == true)
                                        <td scope="col">Finalizada</td>
                                    @elseif(count($obra->producto) == 0 && $obra->terminado == true)
                                        <td scope="col">Sin piezas</td>
                                    @else
                                        <td scope="col">En producción</td>
                                    @endif
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('obraControl', [$obra->idObra])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No existen OT's registradas en el sistema</h4>
                        <br>
                        @endif
                    </div>
                <br>
                @if(Auth::user()->isAdmin())
                    <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addObra')}}"><b>Agregar OT</b></a>
                @endif
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
@endsection
