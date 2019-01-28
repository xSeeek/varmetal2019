@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Asistencias trabajador {{$trabajador->nombre}}</h3>
      </div>
      <div class="card-body">
        @if(count($trabajador->asistencias)==0)
          <h2>No registran asistencias para {{$trabajador->nombre}}</h2>
        @else
          <table class="table display" id="tabla_asistencias" style="width:100%">
            <thead class="thead-dark">
              <th class="text-center">Fecha</th>
              <th class="text-center">Tipo</th>
              <th class="text-center" data-toggle="tooltip" title="Opciones"><i class="fas fa-cogs"></i></th>
            </thead>
            <tbody>
              @foreach ($trabajador->asistencias as $asistencia)
                <tr>
                  <td class="text-center">{{Date::parse($asistencia->created_at)->format('l j M Y H:i:s A')}}</td>
                  <td class="text-center">{{$asistencia->tipo}}</td>
                  <td class="text-center"><a href="{!! route('supervisor.detallesAsistencia', ['rut'=>$trabajador->rut, 'id'=>$asistencia->idAsistencia]) !!}"
                     class="btn btn-primary text-light"
                     role="button" data-toggle="tooltip" data-placement="top"
                     title="Ver detalles asistencia">
                     Ver Detalles
                   </a>
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
      var table = $('#tabla_asistencias').DataTable({
        "language":{
          "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "scrollX": true,
        "autoWidth": false,
      });
    });

  </script>
@endsection
