@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">
    <h1 class="display-4">Bienvenido</h1>
    <p class="lead">Si desea marcar asistencia ingrese su rut</p>
    <div class="row">
      <div class="col-6 col-md-4">
        <form id="form_registrar_asistencia" action="{{route('registrarAsistencia')}}">
          <div class="form-group">
            <input class="form-control" id="rut" type="text" name="rut" placeholder="Ingrese su rut">
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="button" onclick="marcar_asistencia()">Marcar Asistencia</button>
          </div>
          <input type="file" accept="image/*" capture="camera" />
          {{ csrf_field() }}
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });

    function marcar_asistencia()
    {

      var form = $('#form_registrar_asistencia');
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success : function(json)
        {

        },

      });
    }


  </script>
@endsection
