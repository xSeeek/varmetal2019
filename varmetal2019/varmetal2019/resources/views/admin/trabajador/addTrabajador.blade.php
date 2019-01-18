@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo Operador</div>
                <div class="card-body">
                    <form method="POST" name="nuevoTrabajadorForm" id="nuevoTrabajadorForm">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Usuario') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" aria-describedby="email" placeholder="Email del Trabajador" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row" id="passwordForm">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <input class="form-control" id="password" type="text" aria-describedby="password" placeholder="Contraseña del Trabajador" name="password" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="generarPassword()" type="button">Generar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre completo del Operador:</label>
                            <div class="col-md-6">
                                <input type="text" id="nombreCompleto" class="form-control" aria-describedby="nameTrabajador" placeholder="Nombre del Trabajador" name="nameTrabajador" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">RUT del Operador:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="rut" aria-describedby="rutTrabajador" placeholder="RUT del Trabajador" name="rutTrabajador" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Tipo:</label>
                            <div class="col-md-6">
                                <select class="custom-select" id="inputType" aria-describedby="inputType" name="type" required>
                                        <option value="1">Administrador</option>
                                        <option selected value="0">Operador</option>
                                        <option value="2">Supervisor</option>
                                        <option value="3">Gerente</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <button class="btn btn-primary mb-2" id='saveTrabajador' onclick="saveTrabajador()">Registrar Cambios</a>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuTrabajador')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">

function emailRegistrado()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoTrabajadorForm').serialize(),
            url: "{{url('/enviarEmailRegistrado')}}",
            success: function(response){
                if(response!='Email enviado registrado')
                    showMensajeSwall(MSG_ERROR, response);
                else
                  window.location.href = "{{url('menuTrabajador')}}";

          }
        });
    }

    $(document).ready(function() {
        $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });

    function saveTrabajador()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoTrabajadorForm').serialize(),
            url: "{{url('trabajadorControl/addTrabajador')}}",
            success: function(response){
                if(response != 1)
                    showMensajeBanner(MSG_ERROR, response);
                else
                  emailRegistrado();
            }
        });
    }
    function validateStatus()
    {
        var hiddenStatus;
        hiddenStatus = document.getElementById("verifyUser").value;
        if(hiddenStatus == 1)
        {
            document.getElementById("statusUser").value = 1;
            document.getElementById("passwordForm").hidden = true;
            return;
        }
        document.getElementById("statusUser").value = 0;
        document.getElementById("passwordForm").hidden = false;
        return;
    }
    function generarPassword()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{route('admin.createPassword')}}",
            success: function (response) {
                $('#password').attr('value', response);
            },
            error: function (response) {
                showMensajeBanner(MSG_ERROR, 'Ocurrio un error inesperado, contacte con el soporte técnico');
            }
        });
    }
    window.onload = generarPassword;
</script>
@endsection
