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
                    Detalle de la Pieza
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Código de la Pieza:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="codigoProducto" class="form-control-plaintext" value="{{$producto->codigo}}">
                        </div>
                        <b>Nombre del Pieza: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$producto->nombre}}">
                        </div>
                        <b>Tipo de pieza:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="{{$tipo->nombreTipo}}">
                        </div>
                        <b>Fecha de registro de la pieza:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$producto->fechaInicio}}">
                        </div>
                        <b>Fecha de confirmación de término:</b>
                        <div class="col-sm-10">
                            @if($producto->fechaFin == NULL)
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Aún no se finaliza">
                            @else
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="{{$producto->fechaFin}}">
                            @endif
                        </div>
                        <b>Área unitaria en Metros Cuadrados: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="areaProducto" class="form-control-plaintext" value="{{$producto->area}}">
                        </div>
                        <b>Peso unitario en Kilogramos: (Editable)</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="pesoProducto" class="form-control-plaintext" value="{{$producto->pesoKg}}">
                        </div>
                        <b>OT a la que pertenece:</b>
                        <div class="col-sm-10">
                            @if($obra != null)
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="{{$obra->codigo}}">
                            @else
                                <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="No asignada">
                            @endif
                        </div>
                        <b>Estado Actual:</b>
                        <div class="col-sm-10">
                            @switch($producto->estado)
                                @case(0)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Por realizar">
                                    @break
                                @case(1)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Finalizado">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="En proceso de desarrollo">
                                    @break
                                @default
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Sin estado definido">
                                    @break
                            @endswitch
                        </div>
                        <b>Cantidad realizada:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="cantidadProducto" class="form-control-plaintext" value="{{$cantidadProducida}}/{{$producto->cantProducto}}">
                        </div>
                        <div id="nuevaCantidad" class="col-sm-10" style="display:none;">
                          <b>Nueva Cantidad: (Editable)</b>
                            <input type="text" id="cantidadProductoNuevo" class="form-control-plaintext" value="{{$producto->cantProducto}}">
                        </div>
                        <b>Prioridad:</b>
                        <div id="prioridad" class="col-sm-10">
                            @switch($producto->prioridad)
                                @case(1)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Baja">
                                    @break
                                @case(2)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Baja">
                                    @break
                                @case(3)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media">
                                    @break
                                @case(4)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Alta">
                                    @break
                                @case(5)
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Alta">
                                    @break
                                @default
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Sin prioridad">
                                    @break
                            @endswitch
                        </div>
                        <div id="prioridadEdit" style="display:none;" class="col-md-6">
                          <br>
                          <select class="custom-select" id="inputPrioridad" aria-describedby="inputPrioridad" name="inputPrioridad" required>
                                  <option selected value="{{$producto->prioridad}}">
                                    @switch($producto->prioridad)
                                        @case(1)
                                            Baja
                                            @break
                                        @case(2)
                                            Media Baja
                                            @break
                                        @case(3)
                                            Media
                                            @break
                                        @case(4)
                                            Media Alta
                                            @break
                                        @case(5)
                                            Alta
                                            @break
                                        @default
                                            Sin prioridad
                                            @break
                                    @endswitch
                                  </option>
                                  <option value="1">Baja</option>
                                  <option value="2">Media Baja</option>
                                  <option value="3">Media</option>
                                  <option value="4">Media Alta</option>
                                  <option value="5">Alta</option>
                          </select>
                          <br><br>
                        </div>
                        <b>Horas Hombre Requeridas:</b>
                        <div class="col-sm-10">
                            @if($horasHombre != 0)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$horasHombre}} Horas">
                            @elseif($horasHombre == 0 && $producto->terminado == false)
                              <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="Aún no transcurre una hora">
                            @elseif($horasHombre == 0 && $producto->terminado == true)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="Se completó la pieza en menos de una hora">
                            @else
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="No se ha iniciado el desarrollo de la pieza">
                            @endif
                        </div>
                        <b>Horas en Pausa:</b>
                        <div class="col-sm-10">
                            @if($tiempoPausa != 0)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$tiempoPausa}} Horas">
                            @elseif($tiempoPausa == 0 && $producto->pausa == NULL)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="No se han solicitado pausas">
                            @elseif($tiempoPausa == 0 && $producto->pausa != NULL)
                                <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="El producto aún no está 1 hora en pausa">
                            @endif
                        </div>
                        <b>Horas en SetUp:</b>
                        <div class="col-sm-10">
                          @if($tiempoSetUp != 0)
                              <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="{{$tiempoSetUp}} Horas">
                          @elseif($tiempoSetUp == 0 && $producto->pausa == NULL)
                              <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="No se han solicitado cambios de pieza">
                          @elseif($tiempoSetUp == 0 && $producto->pausa != NULL)
                              <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="El producto aún no está 1 hora en SetUp">
                          @endif
                        </div>
                        @if($producto->estado == 1 && $producto->terminado == false)
                            <br>
                            <b style="color:red">Información Importante:</b>
                            <div class="col-sm-10">
                                <input type="text" readonly id="pesoProducto" style="color:red" class="form-control-plaintext" value="Este producto se marcó como terminado.">
                            </div>
                        @endif
                    </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Operadores activos</div>
                <div class="card-body">

                @if(($trabajadores != NULL) && (count($trabajadores)>0))
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Kg realizados</th>
                            <th>Estado</th>
                            <th>Ficha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trabajadores as $key => $trabajador)
                        <tr id="id_Trabajador{{ $trabajador->idTrabajador }}">
                            <td scope="col">{{ $trabajador->rut }}</td>
                            <td scope="col">{{ $trabajador->nombre }}</td>
                            <td scope="col">{{ $trabajador->cargo }}</td>
                            <td scope="col">{{ $trabajador->pivot->kilosTrabajados }}</td>
                            @if($trabajador->pivot->fechaComienzo == NULL)
                                <td scope="col">Aún no inicia</td>
                            @else
                                @if($producto->terminado == false)
                                    <td scope="col">Inició el desarrollo</td>
                                @else
                                    <td scope="col">Completada</td>
                                @endif
                            @endif
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" href="{{url('trabajadorControl', [$trabajador->idTrabajador])}}" role="button"><b>Ficha Trabajador</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteWorker({{ $trabajador->idTrabajador }}, {{ $producto->idProducto }})" role="button"><b>Eliminar</b></a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                </br>
                    <h4 align="center">No hay Operadores asignados.</h4>
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
                @if($obra == NULL)
                <h5>
                    Asignar OT:
                </br>
                    <a class="btn btn-outline-danger btn-md" id="asignarButton" role="button" href="{{url('producto/asignarObra', [$producto->idProducto])}}">Asignar</a>
                </h5>
                <br>
                @endif
                <h5>
                    Asignar más Operadores:
                </br>
                    @if($obra != NULL)
                        <a class="btn btn-outline-success btn-md" id="insertButton" role="button" href="{{url('producto/asignarTrabajo', [$producto->idProducto])}}">Asignar</a>
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
<script type="text/javascript">

  function changeStatus()
  {
    var nombreProducto,nuevaCantidad, enableChangesButton, prioridad, prioridadEdit;

    nombreProducto = document.getElementById('nombreProducto');
    pesoProducto = document.getElementById('pesoProducto');
    prioridad = document.getElementById('prioridad');
    areaProducto = document.getElementById('areaProducto');
    prioridadEdit= document.getElementById('prioridadEdit');
    nuevaCantidad= document.getElementById('nuevaCantidad');
    nombreProducto.removeAttribute("readonly");
    pesoProducto.removeAttribute("readonly");
    areaProducto.removeAttribute("readonly");
    prioridad.setAttribute("style","display:none;")
    prioridadEdit.removeAttribute("style");
    nuevaCantidad.removeAttribute("style");

    enableChangesButton = document.getElementById('enableChangesButton');
    enableChangesButton.innerText="Guardar Cambios";
    enableChangesButton.setAttribute("onclick","postChangeData()");
    return 'boton cambiado';
  }

  function postChangeData()
  {
    var datos, json_text,nuevaCantidad, cantidadProductoNuevo,select, nombreProducto, pesoProducto, prioridad, prioridadEdit;

    nombreProducto = document.getElementById('nombreProducto');
    areaProducto = $('#areaProducto');
    pesoProducto = document.getElementById('pesoProducto');
    prioridadEdit = document.getElementById('prioridadEdit');
    prioridad = document.getElementById('prioridad');
    select = document.getElementById('inputPrioridad');
    nuevaCantidad = document.getElementById('nuevaCantidad');
    cantidadProductoNuevo = document.getElementById('cantidadProductoNuevo');

    enableChangesButton = document.getElementById('enableChangesButton');

    datos = Array();
    datos[0]= nombreProducto.value;
    datos[1]= pesoProducto.value;
    datos[2]= select.value;
    datos[3]= cantidadProductoNuevo.value;
    datos[4]='{{$producto->idProducto}}';
    datos[5] = areaProducto.val();

    json_text = JSON.stringify(datos);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_text},
        url: "{{url('/productoControlEditar')}}",
        success: function(response){
            window.location.href = "{{url('productoControl',[$producto->idProducto])}}";
        }
    });
          prioridadEdit.setAttribute("style","display:none;");
          prioridad.removeAttribute("style");
          nuevaCantidad.setAttribute("style","display:none;");
          areaProducto.attr('readonly', '');
          enableChangesButton.innerText="Habilitar/Deshabilitar";
          enableChangesButton.setAttribute("onclick","changeStatus()");
          enableChangesButton.setAttribute("readonly","");
  }

    function deleteProducto(data)
    {
      swal({
      title: "Confirmación",
      text: '¿Desea eliminar este producto?',
      type: MSG_QUESTION,
      showCancelButton: true,
      confirmButtonColor: COLOR_SUCCESS,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      cancelButtonColor: COLOR_ERROR,
    }).then((result) => {
      if (result.value) {

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:data},
          url: "{{url('/productoControl/deleteProducto')}}",
          success: function(response){
            window.location.href = "{{url('/menuPiezas')}}";
          }
        });

      }
    });

  }
    function deleteWorker(idTrabajador, idProducto)
    {
      swal({
        title: "Confirmación",
        text: '¿Desea desvincular a este trabajador?',
        type: MSG_QUESTION,
        showCancelButton: true,
        confirmButtonColor: COLOR_SUCCESS,
        confirmButtonText: "Si",
        cancelButtonText: "No",
        cancelButtonColor: COLOR_ERROR,
      }).then((result) => {
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
            url: "{{url('/productoControl/removeWorker')}}",
            success: function(response){
              window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
          });

        }
      });
    }
    function resetProduccion(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/resetProduccion')}}",
            success: function(response){
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
    function finishProduccion(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/finishProduccion')}}",
            success: function(response){
                if(response == 1)
                    window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
                else
                    showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
            }
        });
    }
    function resetProducto(idProducto)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "{{url('/productoControl/resetProducto')}}",
            success: function(response){
                window.location.href = "{{url('productoControl', [$producto->idProducto])}}";
            }
        });
    }
</script>
@endsection
