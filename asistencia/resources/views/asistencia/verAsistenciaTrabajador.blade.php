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

            </thead>
          </table>
        @endif
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#tabla_obras').DataTable({
        "language":{
          "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "scrollX": true,
        "autoWidth": false,
      });
    });

  </script>
@endsection
