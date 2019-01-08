@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">
    <h1 class="display-4">Bienvenido</h1>
    <p class="lead">Si desea marcar asistencia ingrese su rut</p>
    <div class="row">
      <div class="col-6 col-md-4">
        <form>
          <div class="form-group">
            <input class="form-control" id="rut" type="text" name="rut" placeholder="Ingrese su rut">
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="button">Marcar Asistencia</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });

  </script>
@endsection
