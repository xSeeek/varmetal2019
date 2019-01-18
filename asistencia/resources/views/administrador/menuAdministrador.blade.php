@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h3 class="card-tittle">Administrar Obras</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-body container">
                    @if(count($obras) > 0)
                      <table id="tabla_obras" class="table display" style="width:100%">
                        <thead class="thead-dark">
                          <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center" data-toggle="tooltip" title="Configuraciones"><i class="fas fa-cogs"></i></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($obras as $obra)
                          <tr>
                            <td class="text-center">{{$obra->nombre}}</td>
                            <td class="text-center">
                              <div class="btn-group" role="group">
                                <form action="{!! route('administrador.eliminarObra', ['id'=>$obra->idObra]) !!}" id="form_id_{{$obra->idObra}}" method="post">
                                  <div class="btn-group-vertical">
                                    <a href="{!! route('administrador.detallesObra', ['id'=>$obra->idObra]) !!}"
                                      class="btn btn-primary text-light"
                                      role="button" data-toggle="tooltip" data-placement="top"
                                      title="Ver Detalles">
                                      Ver Detalles
                                    </a>
                                     @csrf
                                     <button type="submit" data-toggle="tooltip" title="Eliminar Obra" class="btn btn-danger text-light"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    @else
                      <h2>No registra ninguna obra</h2>
                    @endif
                  </div>
                  <a href="{!! route('administrador.agregarObra') !!}" class="btn btn-success btn-lg btn-block text-light">Agregar nuevas obras</a>
                </div>
              </div>
            </div>
          </div>
        </div>
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
        'fixedColumns': true,
        "autoWidth": false,
      });
    });


    $("form[id^='form_id_']").submit(function (e, params) {
      var localParams = params || {};
      if (!localParams.send) {
        e.preventDefault();
      }
      confirmMensajeSwal(MSG_INFO, 'Seguro que desea eliminar esta obra?', e);
    });
  </script>
@endsection
