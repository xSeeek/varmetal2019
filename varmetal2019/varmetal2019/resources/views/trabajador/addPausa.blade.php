@extends('layouts.app')

@section('head')
<title>PAUSA</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$producto->nombre}}</div>
                <div class="card-header">{{$producto->fechaInicio}}</div>
                    <div class="card=body">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Detalles</span>
                        </div>
                        <textarea class="form-control" aria-label="Detalles"></textarea>
                      </div>
                  </div>
                  <div class="card header">{{$producto->fechaFin}}</div>
                  <a class="btn btn-primary btn-lg" role="button" href="{{url('detallepProducto', [$producto->idProducto])}}" onclick="$producto->fechaFin=now()"><b>Fin</b></a>
                  <a class="btn btn-primary btn-lg" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}"><b>Volver</b></a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
