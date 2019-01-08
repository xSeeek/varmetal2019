@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos</div>
                    <div class="card=body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Filtro</label>
                            </div>
                            <input class="form-control" type="text" id="inputProducto" onkeyup="filterProducto()" placeholder="Ingrese el Nombre del Producto" title="RUT del Alumno">
                            <a class="btn btn-secondary btn-sm" role="button" href="{{url('addProducto')}}"><b>Agregar Nuevo Producto</b></a>
                        </div>
                        @if(($productos != NULL) && (count($productos) > 0))
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>Nombre</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Cantidad</th>
                                <th>Peso (Kg)</th>
                                <th>Opciones</th>
                            </tr>
                            @foreach($productos as $key => $producto)
                            <tr id="id_producto{{ $producto->idProducto }}">
                                <td scope="col">{{ $producto->nombre }}</td>
                                @switch($producto->prioridad)
                                    @case(1)
                                        <td scope="col">Baja</td>
                                        @break
                                    @case(2)
                                        <td scope="col">Media Baja</td>
                                        @break
                                    @case(3)
                                        <td scope="col">Media</td>
                                        @break
                                    @case(4)
                                        <td scope="col">Media Alta</td>
                                        @break
                                    @case(5)
                                        <td scope="col">Alta</td>
                                        @break
                                    @default
                                        <td scope="col">Sin prioridad</td>
                                        @break
                                @endswitch
                                @switch($producto->estado)
                                    @case(0)
                                        <td scope="col">Por realizar</th>
                                        @break
                                    @case(1)
                                        <td scope="col">Finalizado</th>
                                        @break
                                    @case(2)
                                        <td scope="col">En realización</th>
                                        @break
                                    @default
                                        <td scope="col">Sin estado definido</th>
                                        @break
                                @endswitch
                                <td scope="col">{{ $producto->cantProducto }}</td>
                                <td scope="col">{{ $producto->pesoKg }}</td>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('productoControl', [$producto->idProducto])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <br>
                            <h4 align="center">No existen productos registrados en el sistema</h4>
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
    function filterProducto()
    {
        var input, table, tr, tdYear, i;
        inputRUT = document.getElementById("inputProducto").value;
        table = document.getElementById("tablaAdministracion");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++)
        {
            tdYear = tr[i].getElementsByTagName("td")[0];
            if(tdYear)
            {
                if ((tdYear.innerHTML.indexOf(inputRUT) > -1))
                    tr[i].style.display = "";
                else
                    tr[i].style.display = "none";
            }
        }
    }
</script>
@endsection
