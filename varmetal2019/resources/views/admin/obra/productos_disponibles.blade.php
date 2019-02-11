@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Piezas</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            @if(($productos_almacenados != NULL) && (count($productos_almacenados) > 0))
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Nombre</th>
                                        <th>Código</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos_almacenados as $key => $producto)
                                    <tr id="id_trabajador{{ $producto->idProducto }}">
                                        <td scope="col"><button class="btn btn-success" onclick="asignarProducto({{$idObra}}, {{$producto->idProducto}})"><i class="far fa-check-square success"></i></button></td>
                                        <td scope="col">{{ $producto->nombre }}</td>
                                        <td scope="col">{{ $producto->codigo }}</td>
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
            <a class="btn btn-primary btn-lg" role="button" href="{{url('obraControl', [$idObra])}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function asignarProducto(idObra, idProducto)
    {
        var datosWorker, json_data;

        datosWorker = Array();
        datosWorker[0] = idObra;
        datosWorker[1] = idProducto;

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
                    window.location.reload();
            }
        });
    }
</script>
@endsection
