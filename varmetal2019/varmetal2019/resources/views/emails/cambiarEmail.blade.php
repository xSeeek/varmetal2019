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
          Cambiar Email
        </div>
        <div class="card-body">
          <h5>
            <form action="{{ url('/nuevoEmail') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="name">Contraseña Actual</label>
                  <input type="password" name="actual_password" class="form-control" id="actual_password">
                </div>
                <div class="form-group">
                  <label for="name">Nuevo Email</label>
                  <input type="email" name="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                  <label for="name">Confirmar Email</label>
                  <input type="email" name="email_confirmation" class="form-control" id="email_confirmation">
                </div>
                <button type="submit" class="btn btn-primary">Cambiar Email</button>
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
