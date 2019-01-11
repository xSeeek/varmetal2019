@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Administrar Obras</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="nombre">Nombre de la obra</label>
          <input type="text" id='nombre' class="form-control" value="{{$obra->nombre}}" disabled>
        </div>
        <div class="form-group">
          <label for="encargado">Encargado de la obra</label>
          <input type="text" name="encargado" class="form-control" value="{{$encargado->nombre}}" disabled>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Asistencia de la obra</h3>
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
                <td class="text-center">{{$trabajador->nombre}} @if ($trabajador->user->isSupervisor()) (Supervisor) @endif</td>
                <td class="text-center">
                  <div class="btn-group" role="group">

                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        @endif
      </div>
      <button class="btn btn-success btn-lg btn-block"
       type="button" data-toggle="modal"
       data-target="#registrarTrabajadores">
        Registar trabajadores a esta obra
      </button>
    </div>
  </div>



  <div class="modal fade" id="registrarTrabajadores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{!! route('administrador.registrarTrabajadorObra', ['idObra'=>$obra->idObra]) !!}" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registrar Trabajadores</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <select placeholder="hola"
           data-live-search-placeholder="Puede buscar por nombre o rut"
           data-live-search="true" name="trabajador"
           class="selectpicker form-control{{ $errors->has('trabajadores') ? ' is-invalid' : '' }}">
           @foreach ($trabajadores as $trabajador)
             <option
             @if ($trabajador->user->isSupervisor())
               style="background: #c82828; color: #fff;"
             @endif
             data-tokens="{{$trabajador->nombre}} {{$trabajador->rut}}" value="{{$trabajador->rut}}">
               {{$trabajador->nombre}}
               @if($trabajador->user->isSupervisor())
                 (Supervisor)
               @elseif ($trabajador->obra == $obra)
                 (Trabajador registrado en la obra actual)
               @endif
             </option>
           @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Agregar Trabajadores</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tabla_trabajadores').DataTable({
      "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "scrollX": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
