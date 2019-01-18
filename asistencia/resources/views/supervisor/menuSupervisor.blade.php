@extends('layouts.navbar')

@section('main')
  <div class="container mt-2 mb-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Administrar Obras, Obra: {{$obra->nombre}}</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="nombre">Nombre de la obra</label>
          <input type="text" id='nombre' class="form-control" value="{{$obra->nombre}}" disabled>
        </div>
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
                <td class="text-center">{{$trabajador->nombre}} @if ($trabajador->user->isSupervisor()) (Supervisor) @endif</td>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <a role="button" class="btn btn-primary font-weight-bold text-light" href="{!! route('supervisor.verAsistencia', ['rut'=>$trabajador->rut]) !!}">Ver Asistencia</a>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        @endif
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
        'fixedColumns': true,
        "autoWidth": false,
      });
    });

  </script>
@endsection
