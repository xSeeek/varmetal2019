@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos Disponibles</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            @if(($productos_almacenados != NULL) && (count($productos_almacenados) > 0))
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Nombre</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                        <th>Peso total (Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos_almacenados as $key => $producto)
                                    <tr id="id_trabajador{{ $producto->idProducto }}">
                                        <td scope="col"><button class="btn btn-success" onclick="asignarTrabajo({{$idTrabajador}}, {{$producto->idProducto}})"><i class="far fa-check-square success"></i></button></td>
                                        <td scope="col">{{ $producto->nombre }}</td>
                                        <td scope="col">{{ $producto->prioridad }}</td>
                                        @if(1 == 1)
                                            <td scope="col">Activo</td>
                                        @else
                                            <td scope="col">Inactivo</td>
                                        @endif
                                        <td scope="col">{{ $producto->cantProducto }}</td>
                                        <td scope="col">{{ $producto->pesoKg }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <br>
                                <h4 align="center">No hay productos disponibles</h4>
                            <br>
                            @endif
                            <br>
                        </div>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('trabajadorControl', [$idTrabajador])}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function formatTable()
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
    function asignarTrabajo(idTrabajador, idProducto)
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
                    window.location.href = "{{url('trabajador/asignarProducto', [$idTrabajador])}}";
                else
                    alert('Error al asignar el producto');
            }
        });
    }
</script>
@endsection
