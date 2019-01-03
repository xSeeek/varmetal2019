@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos en desarrollo</div>
                    <div class="card=body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Filtro</label>
                            </div>
                            <input class="form-control" type="text" id="inputNombre" onkeyup="filterName()" placeholder="Ingrese el nombre del producto" title="Nombre del producto">
                        </div>
                        @if(($productos != NULL) && (count($productos) > 0))
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>Nombre</th>
                                <th>Peso (Kg)</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                <th>Opciones</th>
                            </tr>
                            @foreach($productos as $key => $producto)
                            <tr id="id_producto{{ $producto->idProducto }}">
                                <td scope="col">{{ $producto->nombre }}</td>
                                <td scope="col">{{ $producto->pesoKg }}</td>
                                @if($producto->estado == 0)
                                    <td scope="col">Por Realizar</td>
                                @elseif($producto->estado == 1)
                                    <td scope="col">Finalizado</td>
                                @elseif($producto->estado == 2)
                                    <td scope="col">En realización</td>
                                @endif
                                <td scope="col">{{ $producto->prioridad }}</td>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/detalleProducto', [$producto->idProducto])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <br>
                            <h4 align="center">No tiene productos activos en desarrollo</h4>
                        <br>
                        @endif
                    </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function filterName()
    {
        var input, table, tr, tdYear, i;
        inputNombre = document.getElementById("inputNombre").value;
        table = document.getElementById("tablaAdministracion");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++)
        {
            tdYear = tr[i].getElementsByTagName("td")[0];
            if(tdYear)
            {
                if ((tdYear.innerHTML.indexOf(inputNombre) > -1))
                    tr[i].style.display = "";
                else
                    tr[i].style.display = "none";
            }
        }
    }
</script>
@endsection
