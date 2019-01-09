@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">

    <div class="row">
      <div class="col">
        <h1 class="display-4">Bienvenido</h1>
        <p class="lead">Si desea marcar asistencia ingrese un rut</p>
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
          <img id="img_show" width="100%" class="img-thumbnail" src="{{ Storage::disk('asistencia')->url('default.jpeg') }}"/>
        </div>
      </div>
      <div class="col">
        <h2>Ingresar al menu del administrador</h2>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
      $("#img_select").change(function(){
          readURL(this);
      });
    });

  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      @if (session()->has('success'))
        showMensajeSwall(MSG_SUCCESS, "{{session()->get('success')}}");
       @endif
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
