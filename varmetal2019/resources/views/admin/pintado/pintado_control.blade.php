@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Historial de pintado de la pieza {{$producto->codigo}}</div>
                    <div class="card=body container mt-3">
                        @if(($pintado_revisado != NULL) && (count($pintado_revisado) > 0))
                        <table id="tablaProductos" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Piezas Pintadas</th>
                                    <th>Pintura Utilizada (L)</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pintado_revisado as $key => $pintado)
                                <tr id="id_pintura{{ $pintado->idPintura }}">
                                    <td scope="col">{{ Carbon\Carbon::parse($pintado->dia)->format('d / M / Y') }}</td>
                                    <td scope="col">{{ $pintado->piezasPintadas }}</td>
                                    <td scope="col">{{ $pintado->litrosGastados }}</td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('detalleRevision', [$pintado->idPintura])}}" role="button" style="cursor: pointer;">Detalle Revisión</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            @if($producto->zona == 3)
                                <h4 align="center">La pieza no pasó por el proceso de pintado.</h4>
                            @elseif($producto->zona == 2)
                                <h4 align="center">No se ha revisado ninguna pieza pintada.</h4>
                            @endif
                        <br>
                        @endif
                    </div>
                <br>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="{{url('productoControl', [$producto->idProducto])}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function()
    {
      $('.selectpicker').selectpicker();

        var table = $('#tablaProductos').DataTable({
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "scrollX": true,
       });
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
       });
    });

</script>
@endsection
