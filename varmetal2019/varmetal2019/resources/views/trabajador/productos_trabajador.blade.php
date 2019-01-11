@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos en desarrollo</div>
                    <div class="card-body">
                        @if(($productos != NULL) && (count($productos) > 0))
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Peso (Kg)</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $key => $producto)
                                <tr id="id_producto{{ $producto->idProducto }}">
                                    <td scope="col">{{ $producto->nombre }}</td>
                                    <td scope="col">{{ $producto->pesoKg }}</td>
                                    @switch($producto->estado)
                                        @case(0)
                                            <td scope="col">Por realizar</th>
                                            @break
                                        @case(1)
                                            <td scope="col">Finalizado</th>
                                            @break
                                        @case(2)
                                            <td scope="col">En proceso de desarrollo</th>
                                            @break
                                        @default
                                            <td scope="col">Sin estado definido</th>
                                            @break
                                    @endswitch
                                    @switch($producto->prioridad)
                                        @case(1)
                                            <td scope="col">Baja</td>
                                            @break
                                        @case(2)
                                            <td scope="col">Media Baja</td>
                                            @break
                                        @case(3)
                                            <td scope="col">Media</td>
                                            @break
                                        @case(4)
                                            <td scope="col">Media Alta</td>
                                            @break
                                        @case(5)
                                            <td scope="col">Alta</td>
                                            @break
                                        @default
                                            <td scope="col">Sin prioridad</td>
                                            @break
                                    @endswitch
                                    @if($producto->pivot->fechaComienzo != NULL)
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/detalleProducto', [$producto->idProducto])}}" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                    @else
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" onclick="updateDate({{$producto->idProducto}}, '{{url('/detalleProducto', [$producto->idProducto])}}')" role="button" style="cursor: pointer;">Iniciar Producción</a></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No tiene productos activos en desarrollo</h4>
                        <br>
                        @endif
                    </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function updateDate(idProducto, ruta)
    {
        if (confirm("Presione OK para comenzar con el desarrollo del producto"))
        {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/trabajadorControl/setStartTime')}}",
            success: function(response){
                window.location.href = ruta;
            }
        });
        }
        else
            return;
    }
</script>

@endsection
