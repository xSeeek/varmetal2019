@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--style>
    div.texto {
        display: flex;
        justify-content: center;
    }
  </style-->
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <b>Pausa Del Producto</b>
              </div>
                <div class="card-body">
                  <form method="POST" name="nuevaPausa" id="nuevaPausa">
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Hora Inicio Pausa:</b></label>
                        <div class="col-md-6">
                          <input id="fechaInicio" value="{{$fechaInicio}}" type="timestamp" class="form-control" name="fechaInicio" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Motivo:</b></label>
                        <select class="custom-select" id="motivo" aria-describedby="inputType" name="type" required>
                                <option value="0">Falta materiales</option>
                                <option value="1">Falla en el equipo</option>
                                <option value="2">Falla en el plano</option>
                                <option value="3">Cambio de pieza</option>
                        </select>
                    </div>
                    <div class="form-group row">
                    <div class="text-center" aling="center">
                    <div class="text-center">
                      <label class="col-form-label text-md-center"><b>Descripción: (Mientras ocurre el suceso, detalle con esmeración)</b>
                        <div class="col-md-6">
                          <textarea class="col-md-10" id="descripcion" type="text" aria-describedby="descripcion" placeholder="Descripcion" name="descripcion" cols="50" onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        </div>
                    </div>
                  </div>
                  </form>
                  </div>
                  <div class="text-center">
                    @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
                      @foreach($pausas_almacenadas as $key => $pausa)
                        @if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin == NULL))
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" href="{{url('trabajadorDetallesPausaGet', [$pausa->idPausa])}}"><b>Posee una Pausa Pendiente</b></a>
                          @break
                        @endif
                      @endforeach
                        <!--@if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin != NULL))-->
                              @if($producto->cantPausa<=14)
                                <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="sendEmail()"><b>Registrar Cambios</b></a>
                              @else
                                <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick=""><b>Limite de Pausas alcanzado</b></a>
                              @endif
                        <!--@endif-->
                    @else
                      <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="sendEmail()"><b>Registrar Cambios</b></a>
                    @endif
              </div>
          </div>
      </div>
        <div class="text-center">
          <br>
          <a class="btn btn-primary btn-lg" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}"><b>Volver</b></a>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function textAreaAdjust(o)
    {
        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
    }

    function sendEmail()
        {
          var datosPausa, json_text;

          datosPausa = Array();
          datosPausa[0] = '{{$usuarioActual->trabajador->nombre}}';
          datosPausa[1] = '{{$usuarioActual->trabajador->rut}}';
          datosPausa[2] = '{{$usuarioActual->email}}';
          datosPausa[3] = '{{$producto->cantPausa}}';
          datosPausa[4] = document.getElementById("descripcion").value;
          datosPausa[5] = document.getElementById("motivo").value;

          json_text = JSON.stringify(datosPausa);
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              data: {DATA:json_text},
              url: "{{url('/enviarEmail')}}",
              success: function(response){
                  if(response!='Email enviado')
                  {
                      alert(response);
                      console.log(response);
                  }
                  else
                      //window.location.href="{{url('/trabajadorDetallesPausaGet', [$pausa->idPausa])}}";
                      savePausa();
            }
          });
        }

function savePausa()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = {{$producto->idProducto}};
      datosPausa[1] = document.getElementById("descripcion").value;
      datosPausa[2] = document.getElementById("fechaInicio").value;
      datosPausa[3] = document.getElementById('motivo').value;
      json_text = JSON.stringify(datosPausa);
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "{{url('/SuperPausaControl')}}",
          success: function(response){
              if(response!='Datos almacenados')
              {
                  alert(response);
                  console.log(response);
              }
              else
                  window.location.href="{{url('/addPausa', [$producto->idProducto])}}";
          }
      });
    }

    function updateFechaFin(data, cantPausa)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "{{url('/trabajadorUpdateFechaFinPost')}}",
            success: function(response){
                console.log(response);
                window.location.href = "{{url('/addPausa', [$producto->idProducto])}}";
            }
        });
    }

</script>
@endsection
