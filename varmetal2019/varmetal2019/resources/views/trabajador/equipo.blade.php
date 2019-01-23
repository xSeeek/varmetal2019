@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ayudantes</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            @if(($ayudantes_almacenados != NULL) && (count($ayudantes_almacenados) > 0))
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ayudantes_almacenados as $key => $ayudante)
                                        <tr id="id_ayudante{{ $ayudante->idAyudante }}">
                                            <td scope="col"><button class="btn btn-success" onclick="asignarAEquipo({{$ayudante->idAyudante}}, {{$trabajador->idTrabajador}})"><i class="far fa-check-square success"></i></button></td>
                                            <td scope="col">{{ $ayudante->rut }}</td>
                                            <td scope="col">{{ $ayudante->nombre }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <br>
                                <h4 align="center">No hay Ayudantes disponibles</h4>
                            <br>
                            @endif
                            <br>
                        </div>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('/homepage/Trabajador')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function asignarAEquipo(idAyudante, idTrabajador)
    {
        var datosWorker, json_data;

        datosWorker = Array();
        datosWorker[0] = idAyudante;
        datosWorker[1] = idTrabajador;

        json_data = JSON.stringify(datosWorker);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/trabajadorControl/addAyudante')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('/equipoTrabajador')}}";
                else
                    showMensajeSwall(MSG_ERROR, 'Error al asignar al ayudante');
            }
        });
    }
</script>
@endsection
