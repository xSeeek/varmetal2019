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
                            <input class="form-control" type="text" id="inputPausa" onkeyup="filterPausa()" placeholder="Ingrese el ID del producto" title="ID Producto">
                        </div>
                        @if(($pausas_almacenadas != NULL) && (count($pausas_almacenadas) > 0))
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>ID Producto</th>
                                <th>Nombre Producto</th>
                                <th>Fecha Inicio</th>
                                <th>Descripcion</th>
                                <th>Fecha Fin</th>
                            </tr>
                            @foreach($pausas_almacenadas as $key => $pausa)
                            <tr id="id_pausa{{ $pausa->idPausa }}">
                              <?php
                                $producto = Producto::find($pausa->producto_id_producto);
                              ?>
                                <td scope="col">{{ $producto->idProducto }}</td>
                                <td scope="col">{{ $producto->nombre }}</td>
                                <td scope="col">{{$pausa->fechaInicio}}</td>
                                <td scope="col">{{$pausa->descripcion}}</td>
                                <td scope="col">{{$pausa->fechaFin}}</td>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('pausaControl', [$pausa->idPausa])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay pausas registrados en el sistema</h4>
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