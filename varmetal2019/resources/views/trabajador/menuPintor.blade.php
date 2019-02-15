@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pieza en desarrollo</div>
                <div class="card-body">
                    <h4>
                        <b>Ingrese el codigo de la Pieza:</b>
                    </h4>
                    <div class="col-sm-10">
                        <h2>
                            <input type="text" id="codigoProducto" class="form-control" placeholder="Codigo de la pieza">
                        </h2>
                    </div>
                    <br>
                    <h4>
                        <b>Ingrese la cantidad pintada:</b>
                    </h4>
                    <div class="col-sm-10">
                        <h3>
                            <input type="number" min="1" pattern="^[0-9]+" id="cantidadProducto" class="form-control" placeholder="Cantidad Pintada">
                        </h3>
                    </div>
                </div>
                <a class="btn btn-outline-success my-2 my-sm-0" onclick="actualizarPintado()" role="button" style="cursor: pointer;">Actualizar piezas pintadas</a>
            </div>
            <br>
            <div class="row justify-content-center">
                <a class="btn btn-primary btn-lg" role="button" href="{{url('/homepage/Trabajador')}}"><b>Volver</b></a>
            </div>
        </div>
    </div>
<script type="text/javascript">

    function actualizarPintado()
    {
        var datos, json_text;

        datos = Array();
        datos[0] = document.getElementById('codigoProducto').value;
        datos[1] = document.getElementById('cantidadProducto').value;
        datos[2] = '{{$user->id}}';

        if((datos[0] == "") || (datos[1] == ""))
        {
            showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, 'Faltan datos');
            return;
        }

        json_text = JSON.stringify(datos);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "{{url('/pintarPieza')}}",
            success: function(response){
                if(response == 1)
                    showMensajeSwal(MSG_SUCCESS, BTN_SUCCESS, COLOR_SUCCESS, 'Se pintó ' + datos[1] + ' pieza(s)');
                else
                    showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
            }
        });
        return 1;
    }

</script>
@endsection
