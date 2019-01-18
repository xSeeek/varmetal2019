@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Piezas</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            @if(($obras_disponibles != NULL) && (count($obras_disponibles) > 0))
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Código</th>
                                        <th>Proyecto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($obras_disponibles as $key => $obra)
                                    <tr id="id_trabajador{{ $obra->idObra }}">
                                        <td scope="col"><button class="btn btn-success" onclick="asignarObra({{$idProducto}}, {{$obra->idObra}})"><i class="far fa-check-square success"></i></button></td>
                                        <td scope="col">{{ $obra->codigo }}</td>
                                        <td scope="col">{{ $obra->proyecto }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <br>
                                <h4 align="center">No hay piezas disponibles para asignar al OT</h4>
                            <br>
                            @endif
                            <br>
                        </div>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('productoControl', [$idProducto])}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function asignarObra(idObra, idProducto)
    {
        var datosWorker, json_data;

        datosWorker = Array();
        datosWorker[0] = idProducto;
        datosWorker[1] = idObra;

        json_data = JSON.stringify(datosWorker);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/obraControl/addProducto')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('productoControl', [$idProducto])}}";
                else
                    showMensajeSwall(MSG_ERROR, 'Error al asignar el OT');
            }
        });
    }
</script>
@endsection
