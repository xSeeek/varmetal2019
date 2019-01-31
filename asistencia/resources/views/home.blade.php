@extends('layouts.navbar')

@section('main')

  <div class="jumbotron">
    @if (!Auth::user()->isTrabajador())
      <div class="row">
        <div class="col-sm-5">
          <h1 class="display-4">Bienvenido</h1>
          <p class="lead">Si desea marcar asistencia ingrese un rut</p>
          @if($errors->all() != null)
            <div class="alert alert-danger" role="alert">
               @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
          @endif
          {{ Form::open( array('route' => 'registrarAsistencia', 'files' => true, 'id' => 'form_registrar_asistencia')) }}
            <div class="form-group">
              {{Form::hidden('supervisor', Auth::user()->trabajador->rut)}}
              {{Form::text('rut', null, ['id' => 'rut', 'class' => 'form-control', 'placeholder' => 'Ingrese su rut', 'required'])}}

            </div>
            <div class="form-group">
              {{Form::select('tipo', ['Entrada'=>'Entrada', 'Salida'=>'Salida'], null, ['class' => 'form-control'])}}
            </div>

            <div class="form-group">
              {{Form::file('file', array('class' => 'form-control-file', 'id' => 'img_select', 'accept' => 'image/*', 'required', 'capture' => 'camera'))}}

            </div>

            <div class="form-group">
              {{ Form::submit('Marcar Asistencia', array('class' => 'btn btn-success', 'id'=>'button_submit')) }}
            </div>
          {{ Form::close() }}
          <div class="form-group">
            <img id="img_show" width="100%" class="img-thumbnail" src="{{ Storage::disk('asistencia')->url('default.jpeg') }}"/>
          </div>
        </div>
      </div>
    </div>
  @endif

  <script type="text/javascript">
    $(document).ready(function() {
      $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: true});

      $('input#rut').keyup(function(){
        $(this).val($(this).val().toUpperCase());
      });

      $("#img_select").change(function(){
          readURL(this);
      });
    });

    $('#form_registrar_asistencia').submit(function (e, params) {
      var localParams = params || {};
      if (!localParams.send) {
        e.preventDefault();
      }
      confirmMensajeSwal(MSG_INFO, 'Seguro de marcar asistencia?', e);
    });

    $('#img_select').bind('change', function() {

      //this.files[0].size         gets the size of your file and then you can validate accourdingly...

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_show').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }
  </script>
@endsection
