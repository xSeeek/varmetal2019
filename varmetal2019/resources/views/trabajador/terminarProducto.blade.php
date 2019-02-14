@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Producto en desarrollo</div>
                <div class="card-body">
                  <h4>
                    <b>Ingrese el codigo del Producto:</b>
                  </h4>
                    <div class="col-sm-10">
                      <h2>
                        <input type="text" id="codigoProducto" class="form-control" placeholder="Codigo del producto">
                      </h2>
                    </div>
                    <br>
                    <h4>
                      <b>Ingrese la cantidad:</b>
                    </h4>
                    <div class="col-sm-10">
                      <h3>
                        <input type="number" min="1" pattern="^[0-9]+" id="cantidadProducto" class="form-control" placeholder="Cantidad Producida">
                      </h3>
                    </div>
                </div>
                <a class="btn btn-outline-success my-2 my-sm-0" onclick="productoTerminado()" role="button" style="cursor: pointer;">Producto Terminado</a>
            </div>
            <br>
            <div class="row justify-content-center">
              <a data-target="#exampleModal" data-toggle="modal" class="btn btn-outline-success my-2 my-sm-0" role="button" style="cursor: pointer;">Finalizar Día</a>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Materiales Gastados</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Ingrese la cantidad de alambre en metros gastado:
                      <select class="custom-select" id="alambre" aria-describedby="alambre" name="type" onchange="clasesDiponibles()" required><select><br><br>
                      <input type="number" min="0" pattern="^[0-9]+" id="alambreGastado" class="form-control" placeholder="Alambre gastado"></input><br>
                      Ingrese la cantidad de gas gastado:
                      <select class="custom-select" id="gas" aria-describedby="pintura" name="type" onchange="clasesDiponibles()" required></select><br><br>
                      <input type="number" min="0" pattern="^[0-9]+" id="gasGastado" class="form-control" placeholder="Gas gastado"></input><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="button" onclick="finalizarDia()" class="btn btn-primary">Confirmar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row justify-content-center">
              <a class="btn btn-primary btn-lg" role="button" href="{{url('/homepage/Trabajador')}}"><b>Volver</b></a>
            </div>
        </div>
    </div>
<script type="text/javascript">

window.onload(cargarSelect());

  function cargarSelect()
  {
    var selectAlambre = document.getElementById('alambre');
    var selectGas = document.getElementById('gas');
    var option = document.createElement('option');
    var cont = 0;

    @php
      foreach($materiales as $key => $material)
      {
    @endphp
        var option = document.createElement('option');
        if('{{$material->nombre}}'=='Alambre')
        {
          option.text = '{{$material->codigo}}';
          option.value = '{{$material->idMaterial}}';
          selectAlambre.add(option);
        }
        if('{{$material->nombre}}'=='Gas')
        {
          option.text = '{{$material->codigo}}';
          option.value = '{{$material->idMaterial}}';
          selectGas.add(option);
        }
    @php
      }
    @endphp
  }

  function productoTerminado()
  {
    var datos, json_text;

    datos = Array();
    datos[0] = document.getElementById('codigoProducto').value;
    datos[1] = document.getElementById('cantidadProducto').value;
    datos[2] = '{{$user->id}}';

    if((datos[0] == "") || (datos[1] == ""))
    {
      showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, 'Faltan datos');
      return 2;
    }

    json_text = JSON.stringify(datos);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_text},
        url: "{{url('/productoTerminado')}}",
        success: function(response){
            if(response == 'La pieza ya fue finalizada')
                showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
            if(response == 'No Existe el trabajador')
                showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
            if(response == 'No Existe el producto')
                showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
            if(response == 1)
                showMensajeSwal(MSG_SUCCESS, BTN_SUCCESS, COLOR_SUCCESS, 'Se actualizó la cantidad');
            else
                showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR, response);
      }
      });
    return 1;
  }

  function finalizarDia()
  {
    var datos, json_text;

    datos = Array();
    datos[0] = document.getElementById('gasGastado').value;
    datos[1] = document.getElementById('alambreGastado').value;
    datos[2] = '{{$user->id}}';
    datos[3] = document.getElementById('alambre').value;
    datos[4] = document.getElementById('gas').value;

    if(((datos[0] || datos[1]) != "") || ((datos[3] || datos[4]) != ""))
    {
      json_text = JSON.stringify(datos);
      $.ajax(
        {
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/materialesGastados')}}",
          success: function(response)
          { 
              if(response != 1)
              {
                  showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
              }
              if(response==1)
              {
                showMensajeSwal(MSG_SUCCESS, BTN_SUCCESS, COLOR_SUCCESS, 'Se Finalizó el Día Completamente');
              }
          }
        });
    }else {
      return 2;
    }
  }
</script>

@endsection
