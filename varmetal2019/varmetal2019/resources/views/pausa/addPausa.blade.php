@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .outer_face {
    position: relative;
    width: 100px; /* width of clock */
    height: 100px; /* height of clock */
    border-radius: 100px; /* clock round corner radius */
    background: white;
    box-shadow: inset 0 0 10px gray;
    border: 0 solid gray; /* thickness of outer border */
    }

  .outer_face::before, .outer_face::after, .outer_face .marker { /* time markers syle */
      content: "";
      position: absolute;
      width: 8px; /* width of 12-6 and 3-9 markers */
      height: 100%;
      background: black;
      z-index: 0;
      left: 50%;
      margin-left: -4px; /* set this value of 1/2 marker width */
      top: 0
      }

  .outer_face::after {
      -moz-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
      -webkit-transform: rotate(90deg);
      transform: rotate(90deg)
      }

  .outer_face .marker {
      background: gray;
      width: 6px; /* width of all other markers */
      margin-left: -3px /* set this value of 1/2 marker width */
      }

  .outer_face .marker.oneseven {
      -moz-transform: rotate(30deg);
      -ms-transform: rotate(30deg);
      -webkit-transform: rotate(30deg);
      transform: rotate(30deg)
      }

  .outer_face .marker.twoeight {
      -moz-transform: rotate(60deg);
      -ms-transform: rotate(60deg);
      -webkit-transform: rotate(60deg);
      transform: rotate(60deg)
      }

  .outer_face .marker.fourten {
      -moz-transform: rotate(120deg);
      -ms-transform: rotate(120deg);
      -webkit-transform: rotate(120deg);
      transform: rotate(120deg)
      }

  .outer_face .marker.fiveeleven {
      -moz-transform: rotate(150deg);
      -ms-transform: rotate(150deg);
      -webkit-transform: rotate(150deg);
      transform: rotate(150deg)
      }

  .inner_face {
      position: relative;
      width: 88%;
      height: 88%;
      background: white;
      -moz-border-radius: 100px;
      -webkit-border-radius: 100px;
      border-radius: 100px;
      z-index: 100;
      left: 6%; /* set this value of 1/2 width value*/
      top: 6% /* set this value of 1/2 height value*/
      }

  .inner_face::before {
      /* clock center circle small */
      width: 10px; /* width of inner circle */
      height: 10px; /* height of inner circle */
      border-radius: 10px;
      margin-left: -9px; /* set this value of 1/2 width value*/
      margin-top: -9px; /* set this value of 1/2 height value*/
      background: black;
      position: absolute;
      top: 50%;
      left: 50%;
      box-shadow: 0 0 30px blue;
      }

  .inner_face::after {
      position: absolute;
      width: 100%;
      font: normal 0.8em Arial;
      color: gray;
      text-align: center;
      top: 85%
      }

  .hand, .hand.hour {
      position: absolute;
      width: 4px; /* width of hour hand */
      height: 30%; /* height of hour hand */
      top: 20%; /* set top to 50% - height */
      left: 50%;
      margin-left: -2px; /* set this value to 1/2 width */
      background: black;
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
      -moz-transform-origin: bottom;
      -ms-transform-origin: bottom;
      -webkit-transform-origin: bottom;
      transform-origin: bottom;
      z-index: -1;
      -moz-box-shadow: 0 0 3px gray;
      -webkit-box-shadow: 0 0 3px gray;
      box-shadow: 0 0 3px gray
      }

  .hand.minute {
      height: 45%; /* height of min hand */
      top: 5%; /* set top to 50% - height */
      width: 5px; /* width of min hand */
      margin-left: -2.5px; /* set this value to 1/2 width */
      }

  .hand.second {
      height: 50%; /* height of sec hand */
      width: 2px; /* width of sec hand */
      margin-left: -1px; /* set this value to 1/2 width */
      top: 0;
      background: red
      }
    </style>
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
                      <label class="col-md-5 col-form-label text-md-right"></label>
                      <div class="col-md-6">
                        <div id="liveclock" class="outer_face">
                              <div class="marker oneseven"></div>
                              <div class="marker twoeight"></div>
                              <div class="marker fourten"></div>
                              <div class="marker fiveeleven"></div>

                              <div class="inner_face">
                                <div class="hand hour"></div>
                                <div class="hand minute"></div>
                                <div class="hand second"></div>
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Hora Inicio Pausa:</b></label>
                        <div class="col-md-6">
                          <input id="fechaInicio" type="timestamp" class="form-control" name="fechaInicio" readonly=”readonly”>
                        </div>
                    </div>
                    <div id="select" class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Motivo:</b></label>
                        <div class="col-md-6">
                          <select class="custom-select form-control text-center" id="motivo" aria-describedby="inputType" name="type" onchange="mostrarDescripcion()" required>
                                  <option select value="4">Otro</option>
                                  <option value="0">Falta materiales</option>
                                  <option value="1">Falla en el equipo</option>
                                  <option value="2">Falla en el plano</option>
                                  <option value="3">Cambio de pieza</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row" id="window">
                      <label class="col-md-4 col-form-label text-md-right"><b>Descripción:</b></label>
                        <div id="mostrarDesw" class="col-md-6">
                          <textarea class="form-control text-center" id="descripcion" type="text" aria-describedby="descripcion" placeholder="Descripcion" name="descripcion" cols="50" onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        </div>
                    </div>
                    <div class="form-group row" id="android">
                      <label class="col-md-4 text-md-center"><b>Descripción:</b></label>
                        <div id="mostrarDes" class="col-md-6">
                          <textarea class="form-control text-center" id="descripcion" type="text" aria-describedby="descripcion" placeholder="Descripcion" name="descripcion" cols="50" onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        </div>
                    </div>
                </form>
                  <div class="text-center">
                    @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
                      @foreach($pausas_almacenadas as $key => $pausa)
                        @if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin == NULL))
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" href="{{url('trabajadorDetallesPausaGet', [$pausa->idPausa])}}"><b>El Producto Posee {{$producto->cantPausa}} Pausa/s<br>(Ver última Pendiente)</b></a><br><br>
                          @break
                        @endif
                      @endforeach
                    @endif
                    @if(($producto->cantPausa)<='14')
                      <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa()"><b>Registrar Cambios</b></a>
                    @else
                      <a class="btn btn-outline-success my-1 my-sm-0" role="button"><b>Limite de pausas alcanzado</b></a>
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

window.onload(esWindows());

function esWindows()
{
  var OSName;
  if (navigator.appVersion.indexOf("Win")!=-1)
  {
    OSName = document.getElementById('android');
    OSName.setAttribute("style","display:none;");
  }else{
    OSName = document.getElementById('window');
    OSName.setAttribute("style","display:none;");
  }
}

var $hands = $('#liveclock div.hand')

window.requestAnimationFrame = window.requestAnimationFrame
                               || window.mozRequestAnimationFrame
                               || window.webkitRequestAnimationFrame
                               || window.msRequestAnimationFrame
                               || function(f){setTimeout(f, 60)}


function updateclock(){
	var curdate = new Date()
	var hour_as_degree = ( curdate.getHours() + curdate.getMinutes()/60 ) / 12 * 360
	var minute_as_degree = curdate.getMinutes() / 60 * 360
	var second_as_degree = ( (curdate.getSeconds()-1) + curdate.getMilliseconds()/1000 ) /60 * 360
	$hands.filter('.hour').css({transform: 'rotate(' + hour_as_degree + 'deg)' })
	$hands.filter('.minute').css({transform: 'rotate(' + minute_as_degree + 'deg)' })
	$hands.filter('.second').css({transform: 'rotate(' + second_as_degree + 'deg)' })
	requestAnimationFrame(updateclock)
}

requestAnimationFrame(updateclock)

setInterval(myTimer, 1000);

function myTimer() {
  var time = document.getElementById('fechaInicio');
  moment.locale('es');
  time.value = moment().format('MMMM Do YYYY, h:mm:ss a');;
}

function mostrarDescripcion()
{
  var etiqueta, valor;
  etiqueta = document.getElementById('android');
  etiquetaw = document.getElementById('window');
  valor = document.getElementById('motivo').value;
  if(valor==4)
  {
    if (navigator.appVersion.indexOf("Win")!=-1)
    {
      etiquetaw.removeAttribute("style");
    }else
      etiqueta.removeAttribute("style");
  }
  if(valor!=4){
    if (navigator.appVersion.indexOf("Win")!=-1)
    {
      etiquetaw.setAttribute("style","display:none;");
    }else
      etiqueta.setAttribute("style","display:none;");
  }
  return 1;
}

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
          datosPausa[6] = '{{$usuarioActual->id}}';

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
                    console.log(response);
                }
            }
          });
        }

function savePausa()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = '{{$producto->idProducto}}';
      datosPausa[1] = document.getElementById("descripcion").value;
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
                  console.log(response);
              }
              else
              sendEmail();
              showMensajeSwall(MSG_SUCCESS, "Pausa Agregada");
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
