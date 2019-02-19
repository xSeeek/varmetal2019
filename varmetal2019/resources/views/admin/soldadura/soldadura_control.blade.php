@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalle de la Pieza {{$producto->codigo}}
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Nombre del Pieza: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$producto->nombre}}">
                        </div>
                        <b>Fecha de confirmación de término:</b>
                        <div class="col-sm-10">
                            @if($producto->fechaFin == NULL)
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Aún no se finaliza">
                            @else
                              @if($fechaTermino==NULL && $producto->zona>'1')
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Esta pieza se saltó la soldadura">
                              @else
                                @if($fechaTermino==NULL && $producto->zona<'1')
                                  <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Esta pieza aún no está lista para soldarse">
                                @else
                                  @if($fechaTermino!=NULL)
                                    <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="{{$fechaTermino}}">
                                  @else
                                    <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Aún no se a soldado esta pieza">
                                  @endif
                                @endif
                              @endif
                            @endif
                        </div>
                        <b>Peso unitario en Kilogramos: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="pesoProducto" class="form-control-plaintext" value="{{$producto->pesoKg}}">
                        </div>
                        <b>OT a la que pertenece:</b>
                        <div class="col-sm-10">
                            @if($producto->obra != null)
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="{{$producto->obra->codigo}}">
                            @else
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="No asignada">
                            @endif
                        </div>
                        <b>Cantidad realizada:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="cantidadProducto" class="form-control-plaintext" value="{{$cantidadProducida}}/{{$producto->cantProducto}}">
                        </div>
                        <div id="nuevaCantidad" class="col-sm-10" style="display:none;">
                          <b>Nueva Cantidad: (Editable)</b>
                            <input type="text" id="cantidadProductoNuevo" class="form-control-plaintext" value="{{$producto->cantProducto}}">
                        </div>
                        @if($producto->zona != 3)
                            <div style="color:darkorange">
                                <b>Zona encargada actual:</b>
                                <div class="col-sm-10">
                                    @switch($producto->zona)
                                        @case(0)
                                            <input type="text" readonly id="zonaProducto" class="form-control-plaintext" style="color:darkorange" value="Taller">
                                            @break;
                                        @case(1)
                                            <input type="text" readonly id="zonaProducto" class="form-control-plaintext" style="color:darkorange" value="Soldadura">
                                            @break;
                                        @case(2)
                                            <input type="text" readonly id="zonaProducto" class="form-control-plaintext" style="color:darkorange"value="Pintura">
                                            @break;
                                        @default:
                                            <input type="text" readonly id="zonaProducto" class="form-control-plaintext" style="color:darkorange" value="No determinado">
                                            @break;
                                        @endswitch
                                </div>
                            </div>
                        @endif
                        @if($producto->estado == 1 && $producto->terminado == false)
                            <br>
                            <b style="color:red">Información Importante:</b>
                            <div class="col-sm-10">
                                <input type="text" readonly id="pesoProducto" style="color:red" class="form-control-plaintext" value="Este producto se marcó como terminado.">
                            </div>
                        @endif
                        <!--h3>
                          <b>Gas Gastado:</b>
                          <div class="col-sm-10">
                              <b>{{$gas}} Tubos</b>
                          </div>
                          <br>
                          <b>Alambre Gastado:</b>
                          <div class="col-sm-10">
                              <b>{{$alambre}} Metros</b>
                          </div>
                        </h3-->
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Operadores activos</div>
                <div class="card-body">

                @if(($soldadores != NULL) && (count($soldadores)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Kg realizados</th>
                            <th>Estado</th>
                            <th>Ficha</th>
                            <th>Reiniciar Piezas</th>
                            <th>Eliminar</th>
                            <th>Añadir piezas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($soldadores as $key => $soldador)
                        <tr id="id_Trabajador{{ $soldador->idTrabajador }}">
                            <td scope="col">{{ $soldador->rut }}</td>
                            <td scope="col">{{ $soldador->nombre }}</td>
                            <td scope="col">{{ $soldador->cargo }}</td>
                            <td scope="col">{{ $soldador->pivot->kilosTrabajados }}</td>
                            @if($soldador->pivot->fechaComienzo == NULL)
                                <td scope="col">Aún no inicia</td>
                            @else
                                @if($producto->terminado == false)
                                    <td scope="col">Inició el desarrollo</td>
                                @else
                                    <td scope="col">Completada</td>
                                @endif
                            @endif
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" href="{{url('trabajadorControl', [$soldador->idTrabajador])}}" role="button"><b>Ficha Trabajador</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="reiniciarWorker({{ $soldador->idTrabajador }}, {{ $producto->idProducto }})" role="button"><b>Reiniciar</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteWorker({{ $soldador->idTrabajador }}, {{ $producto->idProducto }})" role="button"><b>Eliminar</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="añadirPiezas({{ $soldador->idTrabajador }}, '{{ $producto->codigo }}')" role="button"><b>Añadir</b></a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">No hay Soldadores asignados.</h4>
                </br>
                @endif
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuPiezas')}}"><b>Volver</b></a>
    </div>
</div>
<div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="Opciones disponibles" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opciones disponibles:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                <h5>
                    Edicion de datos:
                </br>
                    <a class="btn btn-outline-success btn-md" id="enableChangesButton" role="button" onclick="changeStatus()">Habilitar/Deshabilitar</a>
                </h5>
                <br>
                <h5>
                    Ver Pausas:
                </br>
                    <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="{{url('adminPausasAlmacenadas', [$producto->idProducto])}}">Pausas</a>
                </h5>
                <br>
                <h5>
                    Eliminar Pieza:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteProducto({{$producto->idProducto}})">Eliminar</a>
                </h5>
                <br>
                @if($producto->zona >= 2)
                  <h5>
                      Detalles de Pintado:
                  </br>
                      <a class="btn btn-outline-success btn-md" id="detallesPintadoButton" role="button" href="{{url('pintado/pintadoControl', [$producto->idProducto])}}">Ingresar</a>
                  </h5>
                  <br>
                @endif
                <h5>
                    Asignar Soldadores:
                </br>
                    @if($producto->obra != NULL)
                        <a class="btn btn-outline-success btn-md" id="insertButton" role="button" href="{{url('producto/asignarTrabajoSoldador', [$producto->idProducto])}}">Asignar</a>
                    @else
                        <a class="btn btn-outline-success btn-md" id="insertButton" role="button" disabled>Debe asignar el producto a un OT primero</a>
                    @endif
                </h5>
                @if($producto->terminado == false)
                    @if($producto->estado == 1)
                        <br>
                        <h5>
                            Anular Termino:
                        </br>
                            <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProduccion({{$producto->idProducto}})">Reiniciar</a>
                        </h5>
                        <br>
                        <h5>
                            Terminar Pieza:
                        </br>
                            <a class="btn btn-outline-danger btn-md" id="finishButton" role="button" onclick="finishProduccion({{$producto->idProducto}})">Terminar</a>
                        </h5>
                    @endif
                @else
                    <br>
                    <h5>
                        Reiniciar Pieza:
                    </br>
                        <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProducto({{$producto->idProducto}})">Reiniciar</a>
                    </h5>
                @endif
            </div>
        </div>
    </div>
</div>
<script>

function deleteWorker(idTrabajador, idProducto)
{
  swal({
    title: "Confirmación",
    text: '¿Desea desvincular a este soldador?',
    type: MSG_QUESTION,
    showCancelButton: true,
    confirmButtonColor: COLOR_SUCCESS,
    confirmButtonText: "Si",
    cancelButtonText: "No",
    cancelButtonColor: COLOR_ERROR,
  }).then((result) =>
  {
    if (result.value) {

      var data, json_data;

      data = Array();
      data[0] = idTrabajador;
      data[1] = idProducto;

      json_data = JSON.stringify(data);

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_data},
        url: "{{url('/productoControlSoldadura/removeWorker')}}",
        success: function(response){
          window.location.href = "{{url('/soldadura/soldaduraControl', [$producto->idProducto])}}";
        }
      });
    }
  });
}
function reiniciarWorker(idTrabajador, idProducto)
{
  swal({
    title: "Confirmación",
    text: '¿Desea reiniciar las piezas de este soldador?',
    type: MSG_QUESTION,
    showCancelButton: true,
    confirmButtonColor: COLOR_SUCCESS,
    confirmButtonText: "Si",
    cancelButtonText: "No",
    cancelButtonColor: COLOR_ERROR,
  }).then((result) =>
  {
    if (result.value) {


      var data, json_data;

      data = Array();
      data[0] = idTrabajador;
      data[1] = idProducto;

      json_data = JSON.stringify(data);

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_data},
        url: "{{url('/productoControlSoldadura/reiniciarWorker')}}",
        success: function(response){
          window.location.href = "{{url('/soldadura/soldaduraControl', [$producto->idProducto])}}";
        }
      });

    }
  });
}
function añadirPiezas(idTrabajador, codigo)
{
  swal({
  title: "Confirmación",
  input: 'text',
  inputAttributes: {
      autocapitalize: 'off'
  },
  text: "Ingrese la cantidad de piezas a asignar:",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#6A9944",
  confirmButtonText: "Continuar",
  cancelButtonText: "Salir",
  cancelButtonColor: "#d71e1e",
  }).then((result) =>
  {
    if (result.value && result.value>0) {


      var data, json_data;

      data = Array();
      data[0] = idTrabajador;
      data[1] = codigo;
      data[2] = result.value;

      json_data = JSON.stringify(data);

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_data},
        url: "{{url('/productoControlSoldadura/añadirPiezas')}}",
        success: function(response){
          if(response==1)
            window.location.href = "{{url('/soldadura/soldaduraControl', [$producto->idProducto])}}";
          if(response==2)
            showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, 'La pieza aún no está lista para soldarse');
          else
            if(response!=1)
              showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
        }
      });

    }
  });
}
</script>
@endsection
