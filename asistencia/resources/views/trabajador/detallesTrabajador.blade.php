@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Datos personales trabajador</h3>
      </div>
      <div class="card-body">
        <form id="form_id_editar" action="">
          <div class="form-group">
            <label for="nombre">Nombre del trabajador</label>
            <input type="text" id='nombre' class="form-control" value="{{$trabajador->nombre}}" readonly name="nombre_completo">
          </div>
          <div class="form-group">
            <label for="rut">Rut del trabajador</label>
            <input type="text" class="form-control" id="rut" value="{{$trabajador->rut}}" readonly name="rut">
          </div>
          <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" class="form-control" value="{{$trabajador->cargo}}" readonly name="cargo">
          </div>
          <div class="form-group">
            <div class="form-group">
              <button type="button" class="btn btn-outline-info" onclick="habilitarEdicion()">Habilitar Edición</button>
              <button class="btn btn-success" type="submit" id="btn_editar" hidden>Editar</button>
            </div>
        </form>
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
