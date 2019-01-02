@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajadores</div>
                    <div class="card=body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Filtro</label>
                            </div>
                            <input class="form-control" type="text" id="inputRUT" onkeyup="filterRUT()" placeholder="Ingrese el RUT" title="RUT del Alumno">
                            <a class="btn btn-secondary btn-sm" role="button" href="{{url('addTrabajador')}}"><b>Agregar Nuevo Trabajador</b></a>
                        </div>
                        @if(($trabajadores_almacenados != NULL) && (count($trabajadores_almacenados) > 0))
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                            @foreach($trabajadores_almacenados as $key => $trabajador)
                            <tr id="id_alumnoSistema{{ $trabajador->idTrabajador }}">
                                <td scope="col">{{ $trabajador->rut }}</td>
                                <td scope="col">{{ $trabajador->nombre }}</td>
                                @if($trabajador->estado == 1)
                                    <td scope="col">Activo</td>
                                @else
                                    <td scope="col">Inactivo</td>
                                @endif
                                <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('trabajadorControl', [$trabajador->idTrabajador])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay trabajadores registrados en el sistema</h4>
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
    function filterRUT()
    {
        var input, table, tr, tdYear, i;
        inputRUT = document.getElementById("inputRUT").value;
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
