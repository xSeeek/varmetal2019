@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Información del Trabajador</div>
                <div class="card-body">
                    <h5>
                        <b>Nombre Completo:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreTrabajador" class="form-control-plaintext" value="{{$trabajador->nombre}}">
                        </div>
                        <b>RUT:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="rutTrabajador" class="form-control-plaintext" value="{{$trabajador->rut}}">
                        </div>
                        <b>Estado:</b>
                        <div class="col-sm-10">
                        @if($trabajador->rut == true)
                            <input type="text" readonly id="estadoTrabajador" class="form-control-plaintext" value="Activo">
                        @else
                            <input type="text" readonly id="estadoTrabajador" class="form-control-plaintext" value="Inactivo">
                        @endif
                        </div>
                    </h5>
                    <h5>
                        <b>Correo:</b>
                        <div class="col-sm-10">
                            <input type="email" class="form-control-plaintext" readonly id="correoTrabajador" value="{{$usuario_trabajador->email}}">
                        </div>
                    </h5>
                    <br>
                    <a class="btn btn-primary btn-md" id='changesButton' role="button" onclick="saveChanges()" hidden>Guardar Cambios</a>
                </div>
            </div>
        </br>
            <div class="card">
                <div class="card-header">Productos a Realizar</div>
                <div class="card-body">

                @if(($productos_trabajador != NULL) && (count($productos_trabajador)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Peso (kg)</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos_trabajador as $key => $productos)
                            <tr id="id_productoTrabajador{{ $productos->idProductos }}">
                                <td scope="col">{{ $productos->nombre }}</td>
                                <td scope="col">{{ $productos->fechaInicio }}</td>
                                @if($productos->fechaFin != NULL)
                                    <td scope="col">{{ $productos->fechaFin }}</td>
                                @else
                                    <td scope="col">No determinada</td>
                                @endif
                                @switch($productos->estado)
                                    @case(0)
                                        <td scope="col">Por realizar</td>
                                        @break
                                    @case(1)
                                        <td scope="col">Finalizado</td>
                                        @break
                                    @case(2)
                                        <td scope="col">En realización</td>
                                        @break
                                    @default
                                        <td scope="col">Sin estado definido</td>
                                        @break
                                @endswitch
                                <td scope="col">{{ $productos->pesoKg }}</td>
                                <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteProducto({{ $trabajador->idTrabajador }}, {{ $productos->idProducto }})" role="button"><b>Eliminar</b></a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">El trabajador no ha realizado ningún trabajo.</h4>
                </br>
                @endif
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminTrabajador')}}"><b>Volver</b></a>
        </div>
        <div class="card">
            <div class="card-header">Opciones de Administración</div>
            <div class="card-body" align="center">
                <h6>
                    Edicion de datos:
                </br>
                    <a class="btn btn-outline-success btn-md" id="enableChangesButton" role="button" onclick="changeStatus()">Habilitar/Deshabilitar</a>
                </h6>
            <br>
                <h6>
                    Borrar Trabajador:
                </br>
                    <a class="btn btn-outline-success btn-md" role="button" onclick="deleteTrabajador({{$trabajador->idTrabajador}})">Borrar</a>
                </h6>
            </br>
                <h6>
                    Asignar nuevos productos:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" href="{{url('trabajador/asignarProducto', [$trabajador->idTrabajador])}}">Asignar</a>
                </h6>
            </div>
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
    function deleteTrabajador(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('/trabajadorControl/deleteTrabajador')}}",
            success: function(response){
                console.log(response);
                window.location.href = response.redirect;
            }
        });
    }
    function deleteProducto(idTrabajador, idProducto)
    {
        var data, json_data;

        data = Array();
        data[0] = idTrabajador;
        data[1] = idProducto;

        json_data = JSON.stringify(data);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/productoControl/removeWorker')}}",
            success: function(response){
                console.log('asd');
                window.location.href = "{{url('trabajadorControl', [$trabajador->idTrabajador])}}";
            }
        });
    }
</script>
@endsection
