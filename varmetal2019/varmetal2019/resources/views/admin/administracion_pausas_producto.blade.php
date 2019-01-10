@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pausas</div>
                    <div class="card=body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Filtro</label>
                            </div>
                            <input class="form-control" type="text" id="inputPausa" onkeyup="filterPausa()" placeholder="Ingrese el ID de la Pausa" title="ID Pausa">
                        </div>
                        @if(($pausas_almacenadas != NULL) && (count($pausas_almacenadas) > 0))
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>ID Pausa</th>
                                <th>ID Producto</th>
                                <th>Nombre Producto</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                            </tr>
                            @foreach($pausas_almacenadas as $key => $pausa)
                                @if($pausa->producto_id_producto == $producto->idProducto)
                                  <tr id="id_pausa{{ $pausa->idPausa }}">
                                      <td scope="col">{{ $pausa->idPausa}}</td>
                                      <td scope="col">{{ $producto->idProducto }}</td>
                                      <td scope="col">{{ $producto->nombre }}</td>
                                      <td scope="col">{{$pausa->fechaInicio}}</td>
                                      @if($pausa->fechaFin!=NULL)
                                        <td scope="col">{{$pausa->fechaFin}}</td>
                                      @else
                                        <td scope="col">Pendiente</td>
                                      @endif
                                      <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('adminDetallesPausaGet', [$pausa->idPausa])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                  </tr>
                                @endif
                            @endforeach
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay pausas registradas en este Producto</h4>
                        <br>
                        @endif
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
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
