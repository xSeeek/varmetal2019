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
              <a class="btn btn-outline-success my-2 my-sm-0" onclick="finalizarDia()" role="button" style="cursor: pointer;">Finalizar Día</a>
            </div>
            <br>
            <div class="row justify-content-center">
              <a class="btn btn-primary btn-lg" role="button" href="{{url('/homepage/trabajador')}}"><b>Volver</b></a>
            </div>
        </div>
    </div>
<script type="text/javascript">

  function productoTerminado()
  {
    var datos, json_text;

    datos = Array();
    datos[0] = document.getElementById('codigoProducto').value;
    datos[1] = document.getElementById('cantidadProducto').value;

    if((datos[0] || datos[1]) == "")
    {
      return 2;
    }

    json_text = JSON.stringify(datos);

    return;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {DATA:json_text},
        url: "{{url('/productoTerminado')}}",
        success: function(response){
            if(response != 1)
                showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
            }
        });

    return 1;
  }

  function finalizarDia()
  {
    var datos, json_text;

    datos = Array();

    swal({
      title: 'Gastos',
      html:
      '<h4>Alambre en metros</h4>'+
      '<input id="swal-input1" min="1" pattern="^[0-9]+" type="number" class="swal2-input" autofocus placeholder="Alambre Gastado">' +
      '<h4>Gas</h4>'+
      '<input id="swal-input2" min="1" pattern="^[0-9]+" type="number" class="swal2-input" placeholder="Gas Gastado">',
      preConfirm: function() {
          return new Promise(function(resolve) {
          if (true) {
          resolve([
           datos[0] = document.getElementById('swal-input1').value,
           datos[1] = document.getElementById('swal-input2').value
          ]);
          }
          });
      }
      }).then(function(result) {
          if((datos[0] || datos[1]) != "")
          {
            json_text = JSON.stringify(datos);

            return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {DATA:json_text},
                url: "{{url('/materialesGastados')}}",
                success: function(response){
                    if(response != 1)
                        showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
                    }
                });
          }else {
            return 2;
          }
      })
      return 1;
  }

</script>

@endsection
