@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Administrar Obras</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="nombre">Nombre de la obra</label>
          <input type="text" id='nombre' class="form-control" value="{{$obra->nombre}}" disabled>
        </div>
        <div class="form-group">
          <label for="encargado">Encargado de la obra</label>
          <input type="text" name="encargado" class="form-control" value="{{$encargado->nombre}}" disabled>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Asistencia de la obra</h3>
      </div>
    </div>
  </div>
@endsection
