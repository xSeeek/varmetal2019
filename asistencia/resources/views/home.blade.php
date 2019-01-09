@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">
    <h1 class="display-4">Bienvenido</h1>
    <p class="lead">Si desea marcar asistencia ingrese un rut</p>
    <div class="row">
      <div class="col-4 col-md-4">
        <form method="post" id="form_registrar_asistencia" action="{{route('registrarAsistencia')}}" enctype="multipart/form-data">
          <div class="form-group">
            @csrf
            <input class="form-control{{ $errors->has('rut') ? ' is-invalid' : '' }}" id="rut" type="text" name="rut" placeholder="Ingrese un rut" value="{{ old('rut') }}" required autofocus>
            @if ($errors->has('rut'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('rut') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <input type="file" accept="file/*" class="form-control-file{{ $errors->has('file') ? ' is-invalid' : '' }}" id="img_select" value="{{ old('file') }}" capture="camera" name="file" required autofocus/>
            @if ($errors->has('file'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('file') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="submit">Marcar Asistencia</button>
          </div>

        </form>
        <div class="form-group">
          <img src="{{Storage::url('uploads/asistencias/default.jpg')}}" id="img_show" width="100%" class="img-thumbnail"/>
        </div>
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
@endsection
