@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Agregar nuevo trabajador</h3>
      </div>
      <div class="card-body">
        <form action="" id="form_agregar">
          <div class="form-group">
            <input type="email" name="email" value="{{ old('email') }}"
             placeholder="Email Trabajador" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus>
             @if ($errors->has('email'))
               <span class="invalid-feedback" role="alert">
                 <strong>{{ $errors->first('email') }}</strong>
               </span>
             @endif
          </div>
          <div class="form-group">
            <input type="text" name="password" id="password" value="{{ old('password') }}"
             placeholder="Contraseña trabajador(por defecto será su rut)" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
             @if ($errors->has('password'))
               <span class="invalid-feedback" role="alert">
                 <strong>{{ $errors->first('password') }}</strong>
               </span>
             @endif
          </div>
          <div class="form-group">
            <input type="text" name="nombre_completo" value="{{ old('nombre_completo') }}"
             placeholder="Nombre Completo" class="form-control{{ $errors->has('nombre_completo') ? ' is-invalid' : '' }}" required autofocus>
             @if ($errors->has('nombre_completo'))
               <span class="invalid-feedback" role="alert">
                 <strong>{{ $errors->first('nombre_completo') }}</strong>
               </span>
             @endif
          </div>
          <div class="form-group">
            <input type="text" id='rut' name="rut" value="{{ old('rut') }}"
             placeholder="Rut" class="form-control{{ $errors->has('rut') ? ' is-invalid' : '' }}" required autofocus>
             @if ($errors->has('rut'))
               <span class="invalid-feedback" role="alert">
                 <strong>{{ $errors->first('rut') }}</strong>
               </span>
             @endif
          </div>
          <div class="form-group">
            <input type="text" name="cargo" value="{{ old('cargo') }}"
             placeholder="Cargo" class="form-control{{ $errors->has('cargo') ? ' is-invalid' : '' }}" required autofocus>
             @if ($errors->has('cargo'))
               <span class="invalid-feedback" role="alert">
                 <strong>{{ $errors->first('cargo') }}</strong>
               </span>
             @endif
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="submit">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function() {
    $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
  });
  $("form[id^='form_agregar']").submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    confirmMensajeSwal(MSG_INFO, 'Seguro que desea agregar este trabajador?', e);
  });
</script>
@endsection
