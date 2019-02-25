@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalle de Pintado de la Pieza {{$pieza->codigo}}
                </div>
                <div class="card-body">
                    <h5>
                        <b>Área total:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{$pintado->areaPintada * $pintado->piezasPintadas}} m2">
                        </div>
                        <b>Litros de pintura utilizados:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{$pintado->litrosGastados}} L">
                        </div>
                        <b>Espesor de la pintura:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{$pintado->espesor}} mm.">
                        </div>
                        <br>
                        <b style="color:red">Rendimiento:</b>
                        <div class="col-sm-10">
                            <input type="text" style="color:red" readonly class="form-control-plaintext" value="{{$rendimiento}}">
                        </div>
                    </h5>
                        <br>
                    <h4>
                        <b style="color:darkorange">Revisado por:</b>
                    </h4>
                    <h5>
                        <b>Nombre:</b>
                        <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="{{$supervisor->nombre}}">
                        </div>
                        <b>RUT</b>
                        <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="{{$supervisor->rut}}">
                        </div>
                    </h5>
                    <br>
                <h4>
                    <b style="color:darkorange">Pintada por:</b>
                </h4>
                <h5>
                    <b>Nombre:</b>
                    <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{$pintor->nombre}}">
                    </div>
                    <b>RUT</b>
                    <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{$pintor->rut}}">
                    </div>
                </h5>
                </div>
            </div>
            <br>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('pintado/pintadoControl', [$pieza->idProducto])}}"><b>Volver</b></a>
    </div>
</div>
@endsection
