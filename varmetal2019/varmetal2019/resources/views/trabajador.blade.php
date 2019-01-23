@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  Trabajador
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido, <b>{{$trabajador->nombre}}</b>.
                    <br>Correo actual: {{$user->email}}
                    <br>RUT: {{$trabajador->rut}}
                    <br>Cargo: {{$trabajador->cargo}}<br>

                    <br>Mes: <b>@php setlocale(LC_TIME, ''); echo strtoupper(strftime("%B")); @endphp</b>
                    <br>Kilos Realizados: <b>{{$kilosTrabajados}} Kg.</b>

                </div>
            </div>
            </br>
            <div class="card">
              <div class="card-header row justify-content-center">Sus Productos</div>
                          <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/productosTrabajador')}}" role="button" style="cursor: pointer;">Ingresar</a>
            </div>
            </br>
            <div class="card">
              <div class="card-header row justify-content-center">Añadir Ayudantes</div>
                          <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/equipoTrabajador')}}" role="button" style="cursor: pointer;">Ver Ayudantes</a>
            </div>
          </br>
          <div class="card">
            <div class="card-header row justify-content-center">Su Equipo</div>
            <div class="container mt-3">
                @if(($ayudantes_almacenados != NULL) && (count($ayudantes_almacenados) > 0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>Eliminar</th>
                            <th>RUT</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ayudantes_almacenados as $key => $ayudante)
                            <tr id="id_ayudante{{ $ayudante->idAyudante }}">
                                <td scope="col"><button class="btn btn-danger" onclick="asignarAEquipo({{$ayudante->idAyudante}}, {{$trabajador->idTrabajador}})"><i class="fas fa-times success"></i></i></button></td>
                                <td scope="col">{{ $ayudante->rut }}</td>
                                <td scope="col">{{ $ayudante->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <br>
                    <h4 align="center">AÚN NO HA FORMADO UN EQUIPO</h4>
                <br>
                @endif
                <br>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
