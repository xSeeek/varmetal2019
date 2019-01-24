@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Detalles de la asistencia de {{$trabajador->nombre}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
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
            <div class="form-group">
              <label for="tipo">Tipo</label>
              <input type="text" name="tipo" value="{{$asistencia->tipo}}" class="form-control" disabled>
            </div>
          </div>
          <div class="col">
            <figure class="figure">
              <img src="{{ Storage::disk('asistencia')->url($trabajador->rut.'/'.$asistencia->image) }}" class="figure-img img-fluid rounded">
              <figcaption class="figure-caption text-right">Imagen tomada el día en que se marco la asistencia.</figcaption>
            </figure>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
