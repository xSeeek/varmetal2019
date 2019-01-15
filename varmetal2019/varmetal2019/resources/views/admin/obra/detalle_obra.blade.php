@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalle de la Obra
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Nombre del listado de productos:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreListado" class="form-control-plaintext" value="{{$obra->nombre}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Nombre del proyecto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProyecto" class="form-control-plaintext" value="{{$obra->proyecto}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Fecha de creación:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicio" class="form-control-plaintext" value="{{$obra->fechaInicio}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Fecha de finalización:</b>
                        <div class="col-sm-10">
                            @if($obra->fechaFin == null)
                                <input type="text" readonly id="fechaInicio" class="form-control-plaintext" value="Aún no se finaliza.">
                            @else
                                <input type="text" readonly id="fechaInicio" class="form-control-plaintext" value="{{$obra->fechaFin}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Estado de la Obra:</b>
                        <div class="col-sm-10">
                            @if($terminado == true && ($cantidadFinalizada == count($productos_obra)))
                                <input type="text" readonly id="estadoObra" class="form-control-plaintext" value="Terminada">
                            @elseif($cantidadFinalizada == 0)
                                <input type="text" readonly id="estadoObra" class="form-control-plaintext" value="Pendiente">
                            @else
                                <input type="text" readonly id="estadoObra" class="form-control-plaintext" value="En producción">
                            @endif
                        </div>
                    </h5>
                    <br>
                    <h5>
                        <b>Productos finalizados:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$cantidadFinalizada}}/{{count($productos_obra)}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Kilos finalizados:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$kilosTerminados}} Kg / {{$kilosObra}} Kg">
                        </div>
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Productos a Realizar</div>
                <div class="card-body">

                @if(($productos_obra != NULL) && (count($productos_obra)>0))
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
                        @foreach($productos_obra as $key => $productos)
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
                                <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="" role="button"><b>Eliminar</b></a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">La obra poseee ningún producto.</h4>
                </br>
                @endif
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminObras')}}"><b>Volver</b></a>
    </div>
</div>
<div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="Opciones disponibles" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opciones disponibles:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                <h5>
                    Eliminar Obra:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteObra({{$obra->idObra}})">Eliminar</a>
                </h5>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteObra(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('/productoControl/deleteProducto')}}",
            success: function(response){
                window.location.href = response.redirect;
            }
        });
    }
</script>
@endsection
