@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos en desarrollo</div>
                    <div class="card-body">
                        @php $cont = 0 @endphp
                        @if(($productos != NULL) && (count($productos) > 0))
                            @foreach($productos as $key => $producto)
                                @if($producto->terminado == true)
                                    @php $cont++ @endphp
                                @endif
                            @endforeach
                            @if($cont == count($productos))
                                <h4 align="center">No tiene productos activos en desarrollo</h4>
                            @else
                                <table id="tablaProductos" style="width:100%" align="center">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Peso (Kg)</th>
                                            <th>Estado</th>
                                            <th>Prioridad</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $motivo = NULL @endphp
                                    @foreach($productos as $key => $producto)
                                        @if($producto->terminado == false)
                                            @php $cont++ @endphp
                                            <tr id="id_producto{{ $producto->idProducto }}">
                                                <td scope="col">{{ $producto->codigo }}</td>
                                                <td scope="col">{{ $producto->pesoKg }}</td>
                                                @if($producto->pausa != NULL)
                                                    @foreach($producto->pausa as $key => $pausa)
                                                      @if($pausa->trabajador_id_trabajador == $trabajador->idTrabajador)
                                                        @php $motivo = $pausa->motivo @endphp
                                                        @break
                                                      @endif
                                                    @endforeach
                                                @endif
                                                @if($motivo != NULL)
                                                  <td scope="col">{{$motivo}}</th>
                                                @else
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
                                                @endif
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
                                                    <td><a class="btn btn-outline-warning my-2 my-sm-0" id="pickButton{{$producto->idProducto}}" onclick="updateDatos({{$producto->idProducto}})" role="button" style="cursor: pointer;">Seleccionar</a></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                        <br>
                            <h4 align="center">No tiene productos activos en desarrollo</h4>
                        <br>
                        @endif
                    </div>
                    <td><a class="btn btn-outline-success my-2 my-sm-0" hidden onclick="createConjunto()" id = "desarrolloButton" role="button" style="cursor: pointer;">Iniciar Desarrollo</a></td>
            </div>
        </div>
    </div>
<script type="text/javascript">
    var datosSeleccionados = [];
    var index = 0;

    window.onload = function formatTable()
    {
        var table = $('#tablaProductos').DataTable({
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "scrollX": true,
       });
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
       });
    }

    function createConjunto()
    {
        var data;

        if(datosSeleccionados.length > 0)
            data = JSON.stringify(datosSeleccionados);
        else
        {
            showMensajeSwall(MSG_INFO, 'Debe seleccionar almenos una pieza para iniciar la producción');
            return;
        }

        updateDate(data);
    }

    function updateDatos(idProducto)
    {
        datosSeleccionados[datosSeleccionados.length] = idProducto;
        changeButton(idProducto);
    }

    function changeButton(idProducto)
    {
        var button;
        button = document.getElementById('pickButton' + idProducto);

        if(button.innerHTML == 'Seleccionar')
        {
            button.innerHTML = "Eliminar";
            button.setAttribute('class', "btn btn-outline-danger my-2 my-sm-0");
            button.setAttribute('onclick', 'removeProducto(' + idProducto + ')');
        }
        else
        {
            button.innerHTML = "Seleccionar";
            button.setAttribute('class', "btn btn-outline-warning my-2 my-sm-0");
            button.setAttribute('onclick', 'updateDatos(' + idProducto + ')');
        }
        if(datosSeleccionados.length >= 0)
            readyToStart();
    }

    function removeProducto(idProducto)
    {
        for(i = 0; i < datosSeleccionados.length; i++)
            if(datosSeleccionados[i] == idProducto)
            {
                datosSeleccionados.splice(i, 1);
                break;
            }
        if(datosSeleccionados.length < 1)
            datosSeleccionados = [];
        changeButton(idProducto);
    }

    function readyToStart()
    {
        button = document.getElementById('desarrolloButton');

        if(datosSeleccionados.length > 0)
            button.hidden = false;
        else
            button.hidden = true;
    }

    function updateDate(data)
    {
        swal({
        title: "Confirmación",
        text: "Presione Si para iniciar la producción de la(s) pieza(s):",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6A9944",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        cancelButtonColor: "#d71e1e",
        }).then((result) =>
        {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {DATA:data},
                    url: "{{url('/trabajadorControl/setStartTime')}}",
                    success: function(response){
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>

@endsection
