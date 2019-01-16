@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="row">
      <div class="col-sm-5">
        <div class="card">
          <div class="card-header">
            <h3 class="card-tittle">Detalles de la asistencia de {{$trabajador->nombre}}</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="rut">Rut:</label>
              <input type="text" name="rut" value="{{$trabajador->rut}}" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" value="{{$trabajador->nombre}}" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="fecha">Fecha</label>
              <input type="text" name="fecha" value="{{$asistencia->created_at}}" class="form-control" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-header">
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
