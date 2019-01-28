@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Datos personales trabajador</h3>
      </div>
      <div class="card-body">
        <form id="form_id_editar" method="post" action="{!! route('administrador.editarTrabajador') !!}">
          @csrf
          <div class="form-group">
            <label for="nombre">Nombre del trabajador</label>
            <input type="text" id='nombre' class="form-control{{ $errors->has('nombre_completo') ? ' is-invalid' : '' }}" value="{{$trabajador->nombre}}" readonly name="nombre_completo" required>
            @if ($errors->has('nombre_completo'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nombre_completo') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <label for="rut">Rut del trabajador</label>
            <input type="text" class="form-control{{ $errors->has('rut') ? ' is-invalid' : '' }}" id="rut" value="{{$trabajador->rut}}" readonly name="rut" required>
            @if ($errors->has('rut'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('rut') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" class="form-control{{ $errors->has('cargo') ? ' is-invalid' : '' }}" value="{{$trabajador->cargo}}" readonly name="cargo" required>
            @if ($errors->has('cargo'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cargo') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <div class="form-group">
              <button type="button" class="btn btn-outline-info" onclick="habilitarEdicion()">Habilitar Edición</button>
              <button class="btn btn-success" type="submit" id="btn_editar" hidden>Editar</button>
            </div>
          </form>
          <div class="form-group">
            @if(count($trabajador->asistencias)==0)
              <h2>No registran asistencias para {{$trabajador->nombre}}</h2>
            @else
              <a role="button" class="btn btn-primary font-weight-bold text-light" href="{!! route('supervisor.verAsistencia', ['rut'=>$trabajador->rut]) !!}">Ver Asistencia</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  function habilitarEdicion()
  {
    $(document).ready(function() {
      $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });

    $('#form_id_editar input').each( function() {
      if($(this).attr("name")!='email')
      {
        if(verificarEstado($(this))){
          $(this).attr('readonly', false);
          $('#btn_editar').attr('hidden', false);
          return;
        }
        $(this).attr('readonly', true);
        $('#btn_editar').attr('hidden', true);
       }
     });
  }

  $('#form_id_editar').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    confirmMensajeSwal(MSG_INFO, 'Seguro que desea editar este trabajador?', e);
  });

  function verificarEstado(object) {
    return object.attr('readonly') == 'readonly';
  }
  </script>
@endsection
