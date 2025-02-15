@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Personal</div>
                <div class="card=body container mt-3">
                    <table id="tablaAdministracion" style="width:50%; margin:15px;">
                        <tr>
                            <th>Trabajadores</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminTrabajador', [Varmetal\User::DEFAULT_TYPE])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        @if(Auth::user()->isSupervisor() || Auth::user()->isAdmin())
                            <tr>
                                <th>Ayudantes</th>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminAyudante')}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                            </tr>
                        @endif
                        @if(Auth::user()->isAdmin())
                            <tr>
                                <th>Supervisores</th>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminTrabajador', [Varmetal\User::SUPERVISOR_TYPE])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                            </tr>
                            <tr>
                                <th>Gerentes</th>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminTrabajador', [Varmetal\User::GERENCIA_TYPE])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                            </tr>
                            <tr>
                                <th>Administradores</th>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminTrabajador', [Varmetal\User::ADMIN_TYPE])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
    </div>
</div>
@endsection
