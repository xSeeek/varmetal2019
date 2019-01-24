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
                    Información del Ayudante
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Nombre Completo: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreAyudante" class="form-control-plaintext" value="{{$detalles_ayudante->nombre}}">
                        </div>
                        <b>RUT:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="rutAyudante" class="form-control-plaintext" value="{{$detalles_ayudante->rut}}">
                        </div>
                        <b>Estado:</b>
                        <div class="col-sm-10">
                        @if($detalles_ayudante->lider_id_trabajador != NULL)
                            <input type="text" readonly id="estadoAyudante" class="form-control-plaintext" value="Asignado">
                        @else
                            <input type="text" readonly id="estadoAyudante" class="form-control-plaintext" value="No Asignado">
                        @endif
                        </div>
                        <b>Kilos Trabajados (Mes actual):</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="kilosAyudante" class="form-control-plaintext" value="{{$kilosRealizados}} Kg.">
                        </div>
                    </h5>
                    @if($detalles_trabajador != NULL)
                    <br>
                    <br>
                        <h5>
                            <b>Nombre Encargado:</b>
                            <div class="col-sm-10">
                                <input type="email" class="form-control-plaintext" readonly id="nombreEncargado" value="{{$detalles_trabajador->nombre}}">
                            </div>
                        </h5>
                        <h5>
                            <b>RUT Encargado:</b>
                            <div class="col-sm-10">
                                <input type="email" class="form-control-plaintext" readonly id="rutEncargado" value="{{$detalles_trabajador->rut}}">
                            </div>
                        </h5>
                        <h5>
                            <b>Email Encargado:</b>
                            <div class="col-sm-10">
                                <input type="email" class="form-control-plaintext" readonly id="correoEncargado" value="{{$detalles_trabajador->user->email}}">
                            </div>
                        </h5>
                    <br>
                    @endif
                    <a class="btn btn-primary btn-md" id='changesButton' role="button" onclick="saveChanges()" hidden>Guardar Cambios</a>
                </div>
            </div>
        <br>
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
                        Borrar Ayudante:
                    <br>
                        <a class="btn btn-outline-success btn-md" role="button" onclick="deleteAyudante({{$detalles_ayudante->idAyudante}})">Borrar</a>
                    </h5>
                    <br>
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
      datos[1]='{{$detalles_ayudante->idAyudante}}';

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
              window.location.href = "{{url('trabajadorControl',[$detalles_ayudante->idAyudante])}}";
          }
      });
            enableChangesButton.innerText="Habilitar/Deshabilitar";
            enableChangesButton.setAttribute("onclick","changeStatus()");
            enableChangesButton.setAttribute("readonly","");
    }

    function deleteAyudante(data)
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
</script>
@endsection
