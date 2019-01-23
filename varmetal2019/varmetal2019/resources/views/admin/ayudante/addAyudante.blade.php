@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo Ayudante</div>
                <div class="card-body">
                    <form method="POST" name="nuevoAyudanteForm" id="nuevoAyudanteForm">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre completo del Ayudante:</label>
                            <div class="col-md-6">
                                <input type="text" id="nombreCompleto" class="form-control" aria-describedby="nameAyudante" placeholder="Nombre del Ayudante" name="nameAyudante" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">RUT del Ayudante:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="rut" aria-describedby="rutAyudante" placeholder="RUT del Ayudante" name="rutAyudante" required>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <button class="btn btn-primary mb-2" id='saveAyudante' onclick="saveAyudante()">Registrar Cambios</a>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuTrabajador')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });

    function saveAyudante()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoAyudanteForm').serialize(),
            url: "{{url('ayudanteControl/addAyudante')}}",
            success: function(response){
                if(response != 1)
                    showMensajeBanner(MSG_ERROR, response);
                else
                    window.location.href = "{{url('menuTrabajador')}}";
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
</script>
@endsection
