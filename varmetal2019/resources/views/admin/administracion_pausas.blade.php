@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pausas</div>
                    <div class="card=body container mt-3">
                        @if(($pausas_almacenadas != NULL) && (count($pausas_almacenadas) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                          <thead>
                            <tr>
                                <th>OT</th>
                                <th>Codigo Producto</th>
                                <th>Nombre Pieza</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($pausas_almacenadas as $key => $pausa)
                              @foreach($productos_almacenados as $key => $producto)
                                @if($pausa->producto_id_producto == $producto->idProducto)
                                  <tr id="tablaAdministracion">
                                      <td scope="col">{{ $producto->obra->codigo}}</td>
                                      <td scope="col">{{ $producto->codigo}}</td>
                                      <td scope="col">{{ $producto->nombre }}</td>
                                      <td scope="col">{{$pausa->fechaInicio}}</td>
                                      @if($pausa->fechaFin!=NULL)
                                        <td scope="col">{{$pausa->fechaFin}}</td>
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminDetallesPausaGet', [$pausa->idPausa])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                      @else
                                        <td scope="col">Pendiente</td>
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminDetallesPausaGet', [$pausa->idPausa])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                      @endif
                                  </tr>
                                @endif
                              @endforeach
                            @endforeach
                          </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay Pausas registrados en el sistema</h4>
                        <br>
                        @endif
                    </div>
                </div>
              <br>
              <a class="btn btn-primary btn-lg center" align="center" role="button" href="{{url('admin')}}"><b>Volver</b></a>
          </div>
      </div>
</div>
<script type="text/javascript">


    function filterPausa()
    {
        var input, table, tr, tdYear, i;
        inputID = document.getElementById("inputPausa").value;
        table = document.getElementById("tablaAdministracion");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++)
        {
            tdYear = tr[i].getElementsByTagName("td")[0];
            if(tdYear)
            {
                if ((tdYear.innerHTML.indexOf(inputID) > -1))
                    tr[i].style.display = "";
                else
                    tr[i].style.display = "none";
            }
        }
    }
</script>
@endsection
