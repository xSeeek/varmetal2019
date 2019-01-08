@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">
    <h1 class="display-4">Bienvenido</h1>
    <p class="lead">Si desea marcar asistencia ingrese su rut</p>
    <div class="row">
      <div class="col-6 col-md-4">
        <form method="post" id="form_registrar_asistencia" action="{{route('registrarAsistencia')}}">
          <div class="form-group">
            @csrf
            <input class="form-control" id="rut" type="text" name="rut" placeholder="Ingrese su rut" value="{{old('email')}}">
            @if ($errors->has('rut'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('rut') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <input type="file" accept="image/*" id="img_select" capture="camera" name="image"/>
            @if ($errors->has('image'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('image') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <img src="" id="img_show" width="100%" class="img-thumbnail"/>
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="button" onclick="marcar_asistencia()">Marcar Asistencia</button>
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

  <script type="text/javascript">
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#img_show').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#img_select").change(function(){
          readURL(this);
      });
  </script>

  <script type="text/javascript">
    function marcar_asistencia()
    {
    }
  </script>


@endsection
