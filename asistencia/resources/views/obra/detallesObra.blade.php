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
      <div class="card-body">
        @if (count($obra->trabajadores) == 1)
          <h2>No se registran trabajadores en esta obra</h2>
        @endif
      </div>
      <button class="btn btn-success btn-lg btn-block"
       type="button" data-toggle="modal"
       data-target="#registrarTrabajadores">
        Registar trabajadores a esta obra
      </button>
    </div>
  </div>



  <div class="modal fade" id="registrarTrabajadores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Trabajadores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select placeholder="hola"
         data-live-search-placeholder="Puede buscar por nombre o rut"
         data-live-search="true" multiple name="trabajadores"
         class="selectpicker form-control{{ $errors->has('trabajadores') ? ' is-invalid' : '' }}">
         @foreach ($trabajadores as $trabajador)
           <option data-tokens="{{$trabajador->nombre}} {{$trabajador->rut}}"
             value="{{$trabajador->rut}}">
             {{$trabajador->nombre}}
           </option>
         @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Agregar Trabajadores</button>
      </div>
    </div>
  </div>
</div>
@endsection
