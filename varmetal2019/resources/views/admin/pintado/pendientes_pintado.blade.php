@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Piezas pintadas pendientes de revisión</div>
                    <div class="card=body container mt-3">
                        @if(($pendientes != NULL) && (count($pendientes) > 0))
                        <table id="tablaProductos" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Piezas Pintadas</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendientes as $key => $pendiente)
                                <tr id="id_pintura{{ $pendiente->idPintura }}">
                                    <td scope="col">{{ $pendiente->dia }}</td>
                                    <td scope="col">{{ $pendiente->piezasPintadas }}</td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="{{url('detallesPintado', [$pendiente->idPintura])}}" role="button" style="cursor: pointer;">Revisar Pintado</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <br>
                            <h4 align="center">No hay piezas pintadas pendientes de revisión</h4>
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
