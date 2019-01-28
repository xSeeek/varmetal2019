@extends('layouts.navbar')

@section('main')
  <div class="container mt-2 mb-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Administrar Obras, Obra: {{$obra->nombre}}</h3>
      </div>
      <div class="card-body">
        <form method="post" id="form_id_editar" action="{!! route('administrador.editarObra', ['id'=>$obra->idObra]) !!}" id="form_editar">
          @csrf
          <div class="form-group">
            <label for="nombre">Nombre de la obra</label>
            <input type="text" id='nombre' class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{$obra->nombre}}" readonly name="nombre">
            @if ($errors->has('nombre'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nombre') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <label for="encargado">Encargado de la obra</label>
            <input type="text" name="encargado" class="form-control" value="{{$encargado->nombre}}" disabled>
          </div>
          <div class="form-group">
            <div class="form-group">
              <button type="button" class="btn btn-outline-info" onclick="habilitarEdicion()">Habilitar Edición</button>
              <button class="btn btn-primary" data-toggle='modal'
              data-target='#cambiarSupervisor'
              type="button" disabled>
                Cambiar Supervisor
              </button>
            </div>
            <div class="form-group">
              <button class="btn btn-success" type="submit" id="btn_editar" hidden>Editar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Personal de la obra</h3>
      </div>
      <div class="card-body">
        @if (count($obra->trabajadores) == 1)
          <h2>No se registran trabajadores en esta obra</h2>
        @else
          <table id="tabla_trabajadores" class="table display" style="width:100%">
            <thead class="thead-dark">
              <tr>
                <th class="text-center">Rut</th>
                <th class="text-center">Nombre</th>
                <th class="text-center" data-toggle="tooltip" title="Configuraciones"><i class="fas fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($obra->trabajadores as $trabajador)
              <tr>
                <td class="text-center">{{$trabajador->rut}}</td>
                <td class="text-center">{{$trabajador->nombre}}
                  @if($trabajador->user != null)
                    @if ($trabajador->user->isSupervisor())
                      (Supervisor)
                    @endif
                  @endif
                  </td>
                <td class="text-center">
                  <form action="{!! route('administrador.desvincular' ,['rut'=>$trabajador->rut, 'idObra'=>$obra->idObra]) !!}" method="post" id="form_desvincular_{{$trabajador->idTrabajador}}">
                    <div class="btn-group-vertical" role="group">
                      <a role="button" class="btn btn-primary font-weight-bold text-light" href="{!! route('supervisor.verAsistencia', ['rut'=>$trabajador->rut]) !!}">Ver Asistencia</a>
                      @if (Auth::user()->isAdmin())
                        @csrf
                        <button type="submit" class="btn btn-danger"
                          data-toggle="tooltip" data-placement="top"
                          title="Desvincular de la obra">
                          <i class="fas fa-user-slash"></i>
                        </button>
                      @endif
                    </div>
                </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        @endif
      </div>
      @if(Auth::user()->isAdmin())
        <button class="btn btn-success btn-lg btn-block"
         type="button" data-toggle="modal"
         data-target="#registrarTrabajadores">
          Registar trabajadores a esta obra
        </button>
      @endif
    </div>
  </div>

  @if(Auth::user()->isAdmin())
    <div class="modal fade" id="registrarTrabajadores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="form_id_registrarTrabajador" action="{!! route('administrador.registrarTrabajadorObra', ['idObra'=>$obra->idObra]) !!}" method="post">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Registrar Trabajadores</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <select data-live-search-placeholder="Puede buscar por nombre o rut"
              data-live-search="true" name="trabajador"
              class="selectpicker form-control{{ $errors->has('trabajadores') ? ' is-invalid' : '' }}">
              @foreach ($trabajadores as $trabajador)
                @if($trabajador->user->isAdmin() || $trabajador->user->isSupervisor())
                  @break
                @endif
                <option
                data-tokens="{{$trabajador->nombre}} {{$trabajador->rut}}" value="{{$trabajador->rut}}">
                {{$trabajador->nombre}}
              </option>
            @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="btn_submit" class="btn btn-success">Agregar Trabajadores</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif

<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tabla_trabajadores').DataTable({
      "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
      },
      "scrollX": true,
      "autoWidth": false,
    });
  });

  $('#form_id_editar').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    confirmMensajeSwal(MSG_INFO, 'Seguro que desea editar esta obra?', e);
  });

  $('#form_id_registrarTrabajador').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    confirmMensajeSwal(MSG_INFO, 'Seguro que desea agregar este trabajador?', e);
  });

  $("form[id^='form_desvincular_']").submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    confirmMensajeSwal(MSG_INFO, 'Seguro que desea desvincular este trabajador?', e);
  });

  function habilitarEdicion()
  {
    $('#form_id_editar input').each( function() {
      if($(this).attr("name")!='email')
      {
        if(verificarEstado($(this))){
          $(this).attr('readonly', false);
          $('#btn_editar').attr('hidden', true);
          return;
        }
        $(this).attr('readonly', true);
        $('#btn_editar').attr('hidden', false);
       }
     });
  }

  function verificarEstado(object) {
    return object.attr('readonly') == 'readonly';
  }

</script>
@endsection
