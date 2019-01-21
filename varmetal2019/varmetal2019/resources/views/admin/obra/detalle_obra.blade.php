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
                    <b>Detalle de la OT</b>
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Codigo OT:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreListado" class="form-control-plaintext" value="{{$obra->codigo}}">
                        </div>
                    </h5>
                    <h5>
                        <b>Nombre del Proyecto: (Editebla)</b>
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
                            @endif
                        </div>
                    </h5>
                    <h5>
                        <b>Estado de la OT:</b>
                        <div class="col-sm-10">
                            @if($terminado == true && ($cantidadFinalizada == count($productos_obra)) && count($productos_obra) != 0)
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
                    <h5>
                        <b>Tiempo para su realización (Solo piezas terminadas):</b>
                        <div class="col-sm-10">
                            @if($tiempoFinalizado != 0)
                                @if($tiempoFinalizado/60 < 1)
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoFinalizado}} Minutos">
                                @else
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoFinalizado/60}} Horas">
                                @endif
                            @else
                                <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="No se ha finalizado ninguna pieza.">
                            @endif
                        </div>
                        <b>Tiempo en pausa:</b>
                        <div class="col-sm-10">
                            @if($tiempoPausa != 0)
                                @if($tiempoPausa/60 < 1)
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoPausa}} Minutos">
                                @else
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoPausa/60}} Horas">
                                @endif
                            @else
                                <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="No se ha registrado ninguna pausa.">
                            @endif
                        </div>
                        <b>Tiempo en Set-Up:</b>
                        <div class="col-sm-10">
                            @if($tiempoSetUp != 0)
                                @if($tiempoSetUp/60 < 1)
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoSetUp}} Minutos">
                                @else
                                    <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="{{$tiempoSetUp/60}} Horas">
                                @endif
                            @else
                                <input type="text" readonly id="nombreObra" class="form-control-plaintext" value="No se registran pausas por cambio de pieza.">
                            @endif
                        </div>
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Piezas a Realizar</div>
                <div class="card-body">

                @if(($productos_obra != NULL) && (count($productos_obra)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Peso (kg)</th>
                            <th>Ficha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos_obra as $key => $productos)
                            <tr id="id_productoTrabajador{{ $productos->idProducto }}">
                                <td scope="col">{{ $productos->codigo }}</td>
                                <td scope="col">{{ $productos->fechaInicio }}</td>
                                @if($productos->fechaFin != NULL)
                                    <td scope="col">{{ $productos->fechaFin }}</td>
                                @else
                                    <td scope="col">No determinado</td>
                                @endif
                                @switch($productos->estado)
                                    @case(0)
                                        <td scope="col">Por realizar</td>
                                        @break
                                    @case(1)
                                        @if($productos->terminado == true)
                                            <td scope="col">Finalizado</td>
                                        @else
                                            <td scope="col">Pendiente de revisión</td>
                                        @endif
                                        @break
                                    @case(2)
                                        <td scope="col">En realización</td>
                                        @break
                                    @default
                                        <td scope="col">Sin estado definido</td>
                                        @break
                                @endswitch
                                <td scope="col">{{ $productos->pesoKg }} Kg</td>
                                <td scope="col"><a class="btn btn-outline-success btn-sm" href="{{url('productoControl', [$productos->idProducto])}}" role="button"><b>Ficha</b></a>
                                <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="eliminarProducto({{$productos->idProducto}})" role="button"><b>Eliminar</b></a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">La OT no posee ningún producto.</h4>
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
                    Edicion de datos:
                </br>
                    <a class="btn btn-outline-success btn-md" id="enableChangesButton" role="button" onclick="changeStatus()">Habilitar/Deshabilitar</a>
                </h5>
                <h5>
                    @if(count($productos_obra) == 0)
                    Eliminar OT:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteObra({{$obra->idObra}})">Eliminar</a>
                    @endif
                </h5>
                <br>
                <h5>
                    Asignar piezas:
                </br>
                    <a class="btn btn-outline-primary btn-md" id="asignarButton" role="button" href="{{url('obra/productosDisponibles', [$obra->idObra])}}">Asignar</a>
                </h5>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function changeStatus()
    {
      var nombreProyecto, enableChangesButton;

      nombreProyecto = document.getElementById('nombreProyecto');
      nombreProyecto.removeAttribute('readonly');

      enableChangesButton = document.getElementById('enableChangesButton');
      enableChangesButton.innerText="Guardar Cambios";
      enableChangesButton.setAttribute("onclick","postChangeData()");
      return 'boton cambiado';
    }

    function postChangeData()
    {
      var nombreProyecto, enableChangesButton;

      nombreProyecto = document.getElementById('nombreProyecto');

      enableChangesButton = document.getElementById('enableChangesButton');

      datos = Array();
      datos[0] = nombreProyecto.value;
      datos[1] = '{{$obra->idObra}}';

      json_text = JSON.stringify(datos);
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/obraControlEditar')}}",
          success: function(response){
              window.location.reload();
          }
      });
    }

    function deleteObra(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('/obraControl/deleteObra')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('adminObras')}}";
                else
                    showMensajeSwall(MSG_ERROR, response)
            }
        });
    }
    function eliminarProducto(data)
    {
        swal({
        title: "Confirmación",
        text: "Presione Si para eliminar la pieza:",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6A9944",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        cancelButtonColor: "#d71e1e",
        }).then((result) =>
        {
            if (result.value)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {DATA:data},
                    url: "{{url('/obraControl/deleteProducto')}}",
                    success: function(response){
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>
@endsection
