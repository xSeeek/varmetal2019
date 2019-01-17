@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Piezas Disponibles
                </div>
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
                                            <td scope="col">En proceso de desarrollo</th>
                                            @break
                                        @default
                                            <td scope="col">Sin estado definido</th>
                                            @break
                                    @endswitch
                                    <td scope="col">{{ $producto->cantProducto }}</td>
                                    <td scope="col">{{ $producto->pesoKg }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay Piezas disponibles</h4>
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
                    showMensajeSwall(MSG_ERROR, 'Error al asignar la pieza');
            }
        });
    }
</script>
@endsection
