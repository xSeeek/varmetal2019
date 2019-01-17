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
          Cambiar Contraseña
        </div>
        <div class="card-body">
          <h5>
            <form action="{{ url('/nuevaContraseña') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="name">Contraseña Actual</label>
                  <input type="password" name="old_password" class="form-control" id="old_password">
                </div>
                <div class="form-group">
                  <label for="name">Contraseña</label>
                  <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                  <label for="name">Nueva Contraseña</label>
                  <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>
                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
          </h5>
        </div>
      </div>
      <!--a class="btn btn-outline-primary btn-lg" role="button" onclick="cambiarEmail()"><b>Confirmar Cambio</b></a-->
    </div>
  </div>
</div>
@endsection
