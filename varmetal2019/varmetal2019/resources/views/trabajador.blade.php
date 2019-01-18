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

                    Bienvenido, {{$trabajador->nombre}}. <br><br>
                    Correo actual: {{$user->email}} <br><br>
                    Rut: {{$trabajador->rut}} <br><br>
                    Cargo: {{$trabajador->cargo}} <br><br>
                </div>
            </div>
            </br>
            <div class="card">
                <div class="card-heade row justify-content-center">Sus Productos</div>
                            <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/productosTrabajador')}}" role="button" style="cursor: pointer;">Ingresar</a>
            </div>
        </div>
    </div>
</div>
@endsection
