@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Información de la pausa</div>
            </div>
        </br>
            <div class="card">
                <div class="card-body">
                @if(($productos_pausa != NULL) && (count($productos_pausa)>0))
                <table id="tablaCursosAlumno" style="width:90%; margin:20px;">
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        @if(($trabajador_pausa !=NULL && (count($trabajador_pausa)>0)))
                          <table id="tablaTrabajadores" style="width:90%; margin:20px;">
                            <tr>
                                <th>Nombre Trabajador</th>
                                <th>Rut<th>
                            </tr>
                            @foreach($trabajador_pausa as $key => $trabajador)
                                <tr id="id_curso{{ $trabajador->idTrabajador }}">
                                  <td scope="col">{{ $trabajador->rut}}</td>
                                  <td scope="col">{{ $trabajador->nombre}}</td>
                                </tr>
                            @endforeach
                          </table>
                          @else
                          </br>
                              <h4 align="center">No se ha realizado ninguna pausa.</h4>
                          </br>
                        @endif
                        <th>Fecha Inicio</th>
                        <th>Descripcion</th>
                        <th>Fecha Fin</th>
                    </tr>
                    @foreach($productos_pausa as $key => $productos)
                        <tr id="id_cursoAlumno{{ $productos->idProducto }}">
                            <td scope="col">{{ $productos->idProducto }}</td>
                            <td scope="col">{{ $productos->nombre }}</td>
                            <td scope="col">{{ $pausa->fechaInicio }}</td>
                            <td scope="col">{{ $pausa->descripcion}}</td>
                            <td scope="col">{{ $pausa->fechaFin}}</td>
                        </tr>
                    @endforeach
                </table>
                @else
                </br>
                    <h4 align="center">No se ha realizado ninguna pausa.</h4>
                </br>
                @endif
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminTrabajador')}}"><b>Volver</b></a>
        </div>
        <div class="card">
            <div class="card-header">Opciones de Administración</div>
            <div class="card-body">
                <h6>
                    Edicion de datos:
                </br>
                    <a class="btn btn-outline-primary btn-sm" id="enableChangesButton" role="button" onclick="changeStatus()">Habilitar/Deshabilitar</a>
                </h6>
            <br>
            </div>
        </div>
    </div>
</div>
@endsection
