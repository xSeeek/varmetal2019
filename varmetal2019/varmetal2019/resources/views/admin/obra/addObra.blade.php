@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo obra</div>
                <div class="card-body">
                    <form method="POST" name="nuevaObraForm" id="nuevaObraForm">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre de la obra:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="nameObra" placeholder="Nombre de la Obra" name="nameObra" required>
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
                {
                    alert(response);
                    console.log(response);
                }
                else
                    window.location.href = "{{url('adminObras')}}";
            }
        });
    }
</script>
@endsection
