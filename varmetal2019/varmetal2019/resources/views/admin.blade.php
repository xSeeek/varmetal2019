@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administracion</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido, @if(Auth::user()->isSupervisor())
                                    Supervisor
                                @elseif(Auth::user()->isAdmin())
                                    Administrador
                                @endif</br>
                    Correo actual: <?php echo Auth::user()->email?>
                </div>
            </div>
            </br>
            <div class="card">
                <div class="card-header">Administracion</div>
                <div class="card=body container mt-3">
                    <table id="tablaAdministracion" style="width:50%; margin:15px;">
                      @if(($obras != NULL) && (count($obras) > 0))
                        <tr>
                            <th>Administración de Piezas</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminProducto')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                      @else
                        <tr>
                            <th>Para agregar piezas, debe agregar primero una Obra</th>
                        </tr>
                      @endif
                        <tr>
                            <th>Menú Trabajadores</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('menuTrabajador')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                      @if(($pausas != NULL) && (count($pausas) > 0))
                        <tr>
                            <th>Administración de Pausas</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminPausas')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                      @else
                        <tr>
                            <th>No hay pausas registradas</th>
                        </tr>
                      @endif
                        <tr>
                            <th>Administración de OT</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminObras')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        @if(Auth::user()->isAdmin())
                        <tr>
                            <th>Gerencia</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('gerencia')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
