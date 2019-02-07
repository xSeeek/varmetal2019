@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administración de Piezas</div>
                <div class="card=body container mt-3">
                    <table style="width:50%; margin:15px;">
                        <tr>
                            <th>Piezas Pendientes</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminProducto', ['pendientes'])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>

                        <tr>
                            <th>Piezas Esperando Revisión</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminProducto', ['revision'])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>

                        <tr>
                            <th>Piezas Finalizadas</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminProducto', ['terminados'])}}" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                    </table>
                </div>
                <a class="btn btn-outline-success btn-lg" align="right" role="button" href="{{url('/addProducto')}}"><b>Agregar Piezas</b></a>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
    </div>
</div>
@endsection
