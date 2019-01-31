@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo OT</div>
                <div class="card-body">
                    <form method="POST" name="nuevaObraForm" id="nuevaObraForm">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Codigo OT:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="nameListado" placeholder="Nombre del listado" name="nameListado" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre del Proyecto:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="nameProyecto" placeholder="Nombre del proyecto" name="nameProyecto" required>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <button class="btn btn-primary mb-2" id='saveObra' onclick="saveObra()">Registrar Cambios</a>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('adminObras')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function saveObra()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevaObraForm').serialize(),
            url: "{{url('obraControl/addObra')}}",
            success: function(response){
                if(response != 1)
                    showMensajeSwall(MSG_ERROR, response);
                else
                {
                    showMensajeSwall(MSG_SUCCESS, response);
                    window.location.href = "{{url('adminObras')}}";
                  }
            }
        });
    }
</script>
@endsection
