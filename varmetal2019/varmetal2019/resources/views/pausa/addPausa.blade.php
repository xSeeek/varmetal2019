@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    div.texto {
        display: flex;
        justify-content: center;
    }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">Pausa Del Producto
                <div class="card-body">
                  <form method="POST" name="nuevaPausa" id="nuevaPausa">
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">Producto:</label>
                      <div class="col-md-6">
                        <input id="nombreProducto" value="{{$producto->nombre}}" type="text" class="form-control" aria-describedby="nombreProducto" placeholder="Nombre del Producto" name="nombreProducto" readonly=”readonly”>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">ID del Producto:</label>
                        <div class="col-md-6">
                          <input id="idProducto" value="{{$producto->idProducto}}" type="text" class="form-control" aria-describedby="idProducto" placeholder="Id del Producto" name="idProducto" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">Inicio Pausa:</label>
                        <div class="col-md-6">
                          <input id="fechaInicio" value="{{$fechaInicio}}" type="text" class="form-control" aria-describedby="fechaInicio" placeholder="Fecha de Inicio" name="fechaInicio" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="text-center" aling="center">
                    <div class="text-center">
                      <label class="col-form-label text-md-center">Descripción: (Mientras ocurre el suceso, detalle con esmeración)
                        <div class="col-md-6">
                          <textarea class="texto" id="descripcion" type="text" aria-describedby="descripcion" placeholder="Descripcion" name="descripcion" cols="50" onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        </div>
                    </div>
                  </form>
                  @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
                      @if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin == NULL))
                        <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="alert('Primero, Finaliza la pausa pendiente')"><b>Registrar Cambios</b></a>
                      @else
                        @if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin != NULL))
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa()"><b>Registrar Cambios</b></a>
                        @endif
                      @endif
                  @endif
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
        <div class="card-header">Pausa Pendiente</div>
        <div class="card-body" align='center'>
            <h6>
                @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
                  @foreach($pausas_almacenadas as $key => $pausa)
                    @if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin == NULL))
                      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" href="{{url('trabajadorDetallesPausaGet', [$pausa->idPausa])}}">Ver Pausa {{$pausa->idPausa}}</a>
                      <br>
                      <br>
                    @endif
                  @endforeach
                @endif
            </h6>
        </div>
    </div>
  </div>
<script type="text/javascript">

/*function removerAtributo()
{
  var boton;
  boton = document.getElementById("botonLoco");
  boton.removeAttribute("onclick");
  boton.setAttribute("onclick", 'alert('Debe finalizar la Pausa Pendiente')');
}*/

function textAreaAdjust(o)
    {
        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
    }

function savePausa()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = {{$producto->idProducto}};
      datosPausa[1] = document.getElementById("descripcion").value;
      //datosPausa[2] = {{$fechaInicio}};
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
                  window.location.href="{{url('/addPausa', [$producto->idProducto])}}";
          }
      });
    }

    function updateFechaFin(data)
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
