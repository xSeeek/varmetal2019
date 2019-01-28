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
                    Información del Operador
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Nombre Completo: (Editable)</b>
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
                        <b>Correo:</b>
                        <div class="col-sm-10">
                            <input type="email" class="form-control-plaintext" readonly id="correoTrabajador" value="{{$usuario_trabajador->email}}">
                        </div>
                    </h5>
                    <a class="btn btn-primary btn-md" id='changesButton' role="button" onclick="saveChanges()" hidden>Guardar Cambios</a>
                    <h5>
                        <b>Mes:</b>
                        <div class="col-sm-10">
                          <input type="text" readonly id="kilosTrabajados" class="form-control-plaintext" value="@php setlocale(LC_TIME, ''); echo strtoupper(strftime("%B")); @endphp">
                        </div>
                        <h2><b>Kilos Totales Realizados:</b><br>
                        <div class="col-sm-10">
                          <input type="text" readonly id="kilosTrabajados" class="form-control-plaintext" value="{{$kilosTrabajados}} Kg.">
                        </div></h2>
                        <!--b>Bono:</b>
                        <div class="col-sm-10">
                          <input type="text" readonly id="kilosTrabajados" class="form-control-plaintext" value="{{$bono}} pesos.">
                        </div>
                        <b>Sueldo: </b>
                        <div class="col-sm-10">
                          <input type="text" readonly id="kilosTrabajados" class="form-control-plaintext" value="{{$sueldo}} pesos.">
                        </div-->
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Piezas a Realizar</div>
                <div class="card-body">

                @if(($productos_trabajador != NULL) && (count($productos_trabajador)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>Código</th>
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
                                <td scope="col">{{ $productos->codigo }}</td>
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
                    <h4 align="center">El Operador no tiene ningún trabajo en desarrollo.</h4>
                </br>
                @endif
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuTrabajador')}}"><b>Volver</b></a>
        </div>
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
                <br>
                @if(Auth::user()->isAdmin())
                    <h5>
                        Borrar Operador:
                    <br>
                        <a class="btn btn-outline-success btn-md" role="button" onclick="deleteTrabajador({{$trabajador->idTrabajador}})">Borrar</a>
                    </h5>
                    <br>
                @endif
                @if($usuario_trabajador->type == Varmetal\User::DEFAULT_TYPE)
                    <h5>
                        Asignar nuevas Piezas:
                    <br>
                        <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" href="{{url('trabajador/asignarProducto', [$trabajador->idTrabajador])}}">Asignar</a>
                    </h5>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function changeStatus()
    {
      var nombreTrabajador, enableChangesButton;

      nombreTrabajador = document.getElementById('nombreTrabajador');
      nombreTrabajador.removeAttribute("readonly");
      enableChangesButton = document.getElementById('enableChangesButton');
      enableChangesButton.innerText="Guardar Cambios";
      enableChangesButton.setAttribute("onclick","postChangeData()");
      return 'boton cambiado';
    }

    function postChangeData()
    {
      var datos, json_text, enableChangesButton, nombreTrabajador;

      enableChangesButton = document.getElementById('enableChangesButton');
      nombreTrabajador = document.getElementById('nombreTrabajador');

      datos = Array();
      datos[0]= nombreTrabajador.value;
      datos[1]='{{$trabajador->idTrabajador}}';

      json_text = JSON.stringify(datos);
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/trabajadorControlEditar')}}",
          success: function(response){
              alert('Datos Cambiados');
              window.location.href = "{{url('trabajadorControl',[$trabajador->idTrabajador])}}";
          }
      });
            enableChangesButton.innerText="Habilitar/Deshabilitar";
            enableChangesButton.setAttribute("onclick","changeStatus()");
            enableChangesButton.setAttribute("readonly","");
    }

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
                window.location.href = "{{url('menuTrabajador')}}";
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
                window.location.href = "{{url('trabajadorControl', [$trabajador->idTrabajador])}}";
            }
        });
    }
</script>
@endsection
