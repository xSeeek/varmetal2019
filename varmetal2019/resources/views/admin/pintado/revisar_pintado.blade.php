@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalle de Pintado de la Pieza {{$producto->codigo}}</div>
                <div class="card-body">
                    <form method="POST" name="revisarPintadoForm" id="revisarPintadoForm">
                        <input type="text" class="form-control" aria-describedby="idPintura" name="idPintura" value = "{{$idPintura}}" hidden>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Área Pintada:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="areaPintada" placeholder="Área pintada del producto" name="areaPintada" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Litros de pintura gastados:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="pinturaGastada" placeholder="Litros de pintura gastados" name="pinturaGastada" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Espesor de la pintura:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="espesorPintura" placeholder="Espesor de la Pintura" name="espesorPintura" required>
                            </div>
                        </div>
                    </form>
                </div>
                    <button class="btn btn-outline-danger" id='revisarPintado' onclick="revisarPintado()">Marcar como revisada</a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('pintadasPendientes', [$producto->idProducto])}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">

    function revisarPintado()
    {
        swal({
        title: "Confirmación",
        text: 'Presione Si para finalizar la revisión',
        type: MSG_QUESTION,
        showCancelButton: true,
        confirmButtonColor: COLOR_SUCCESS,
        confirmButtonText: "Si",
        cancelButtonText: "No",
        cancelButtonColor: COLOR_ERROR,
        }).then((result) =>
        {
            if (result.value)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: $('#revisarPintadoForm').serialize(),
                    url: "{{url('pintadoControl/revisarPintado')}}",
                    success: function(response){
                        if(response != 1)
                            showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
                        else
                        {
                            showMensajeSwal(MSG_SUCCESS, BTN_SUCCESS, COLOR_SUCCESS, "Se marcó como revisada");
                            window.location.href = "{{url('pintadasPendientes', [$producto->idProducto])}}";
                        }
                    }
                });

            }
        });
    }

</script>
@endsection
