@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajadores</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            @if(($trabajadores_almacenados != NULL) && (count($trabajadores_almacenados) > 0))
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trabajadores_almacenados as $key => $trabajador)
                                    <tr id="id_trabajador{{ $trabajador->idTrabajador }}">
                                        <td scope="col"><button class="btn btn-success" onclick="asignarTrabajo({{$idProducto}}, {{$trabajador->idTrabajador}})"><i class="far fa-check-square success"></i></button></td>
                                        <td scope="col">{{ $trabajador->rut }}</td>
                                        <td scope="col">{{ $trabajador->nombre }}</td>
                                        @if($trabajador->estado == 1)
                                            <td scope="col">Activo</td>
                                        @else
                                            <td scope="col">Inactivo</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <br>
                                <h4 align="center">No hay trabajadores registrados en el sistema</h4>
                            <br>
                            @endif
                            <br>
                        </div>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('admin')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function filterTrabajador()
    {
        var input, table, tr, tdYear, i;
        inputRUT = document.getElementById("inputTrabajador").value;
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
    window.onload = function loadYears()
    {
        var table = $('#tablaAdministracion').DataTable({
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "scrollX": true,
       });
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
       });
    }
    function asignarTrabajo(idProducto, idTrabajador)
    {
        var datosWorker, json_data;

        datosWorker = Array();
        datosWorker[0] = idProducto;
        datosWorker[1] = idTrabajador;

        json_data = JSON.stringify(datosWorker);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/productoControl/addWorker')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('productoControl', [$idProducto])}}";
                else
                    alert('Error al asignar al trabajador');
            }
        });
    return;
    }
</script>
@endsection