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
                <div class="card-header">Productos Realizados Por El Trabajador</div>
                <div class="card-body">

                @if(($productos_trabajador != NULL) && (count($productos_trabajador)>0))
                <table id="tablaCursosAlumno" style="width:90%; margin:20px;">
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Peso (kg)</th>
                    </tr>
                    @foreach($productos_trabajador as $key => $productos)
                        <tr id="id_cursoAlumno{{ $productos->idProductos }}">
                            <td scope="col">{{ $productos->nombre }}</td>
                            <td scope="col">{{ $productos->fechaInicio }}</td>
                            <td scope="col">{{ $productos->fechaFin }}</td>
                            @if($productos->estado == 2)
                                <td scope="col">Terminado</td>
                            @elseif($productos->estado == 3)
                                <td scope="col">En Pausa</td>
                            @else
                                <td scope="col">En Proceso</td>
                            @endif
                            <td scope="col">{{ $productos->pesoKg }}</td>
                            <td scope="col"><a class="btn btn-secondary btn-sm" role="button" onclick="removeProducto({{ $trabajador->idTrabajador }}, {{ $productos->idProductos }})"><b>Eliminar</b></a>
                        </tr>
                    @endforeach
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
            <div class="card-body">
                <h6>
                    Edicion de datos:
                </br>
                    <a class="btn btn-outline-primary btn-sm" id="enableChangesButton" role="button" onclick="changeStatus()">Habilitar/Deshabilitar</a>
                </h6>
            <br>
                <h6>
                    Borrar Trabajador:
                </br>
                    <a class="btn btn-outline-primary btn-sm" role="button" onclick="deleteTrabajador({{$trabajador->idTrabajador}})">Borrar</a>
                </h6>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">


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
</script>
@endsection
