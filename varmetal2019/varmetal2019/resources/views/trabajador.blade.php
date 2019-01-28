@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  Trabajador
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido, <b>{{$trabajador->nombre}}</b>.

                    <br>Mes: <b>@php setlocale(LC_TIME, ''); echo strtoupper(strftime("%B")); @endphp</b>
                    <h3><br>Kilos Totales Realizados: <b>{{$kilosTrabajados}} Kg.</b></h3>
                    <!--br>Bono Producción: <b>{{$toneladas*5500}} pesos.</b-->
                </div>
            </div>
            </br>
            <div class="card">
              <div class="card-header"  align="center">Sus Productos</div>
                          <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/productosTrabajador')}}" role="button" style="cursor: pointer;">Ingresar</a>
            </div>
            </br>
            <div class="card">
              <div class="card-header"  align="center">Añadir Ayudantes</div>
                          <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/equipoTrabajador')}}" role="button" style="cursor: pointer;">Ver Ayudantes</a>
            </div>
          </br>
          <div class="card">
            <div class="card-header" align="center">Su Equipo</div>
            <div class="container mt-3">
                @if(($ayudantes_almacenados != NULL) && (count($ayudantes_almacenados) > 0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>Eliminar</th>
                            <th>RUT</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ayudantes_almacenados as $key => $ayudante)
                            <tr id="id_ayudante{{ $ayudante->idAyudante }}">
                                <td scope="col"><button class="btn btn-danger" onclick="eliminarDeEquipo({{$ayudante->idAyudante}})"><i class="fas fa-times success"></i></i></button></td>
                                <td scope="col">{{ $ayudante->rut }}</td>
                                <td scope="col">{{ $ayudante->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <br>
                    <h4 align="center">AÚN NO HA FORMADO UN EQUIPO</h4>
                <br>
                @endif
                <br>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
<script>
    function eliminarDeEquipo(idAyudante)
    {
        var data, json_data;

        data = Array();
        data[0] = idAyudante;

        json_data = JSON.stringify(data);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "{{url('/ayudanteControl/removeEquipo')}}",
            success: function(response){
                window.location.reload();
            }
        });
      }
</script>
