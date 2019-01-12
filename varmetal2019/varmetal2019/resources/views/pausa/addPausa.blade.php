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
                <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
              </div>
                <div class="card-body">
                  <form method="POST" name="nuevaPausa" id="nuevaPausa">
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Nombre Producto:</b></label>
                      <div class="col-md-6">
                        <input id="nombreProducto" value="{{$producto->nombre}}" type="text" class="form-control" aria-describedby="nombreProducto" placeholder="Nombre del Producto" name="nombreProducto" readonly=”readonly”>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Codigo del Producto:</b></label>
                        <div class="col-md-6">
                          <input id="idProducto" value="{{$producto->codigo}}" type="text" class="form-control" aria-describedby="idProducto" placeholder="Id del Producto" name="idProducto" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Hora Inicio Pausa:</b></label>
                        <div class="col-md-6">
                          <input id="fechaInicio" value="{{$fechaInicio}}" type="timestamp" class="form-control" name="fechaInicio" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="text-center" aling="center">
                    <div class="text-center">
                      <label class="col-form-label text-md-center"><b>Descripción: (Mientras ocurre el suceso, detalle con esmeración)</b>
                        <div class="col-md-6">
                          <textarea class="col-md-10" id="descripcion" type="text" aria-describedby="descripcion" placeholder="Descripcion" name="descripcion" cols="50" onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        </div>
                    </div>
                  </form>
                <div class="row justify-content-center">
                  @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
                    @if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin == NULL))
                      <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick=""><b>Posee una Pausa Pendiente</b></a>
                    @else
                      @if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin != NULL))
                        @if($producto->cantPausa<=14)
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa({{$producto->cantPausa}})"><b>Registrar Cambios</b></a>
                        @endif
                      @else
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick=""><b>Limite de Pausas alcanzado</b></a>
                      @endif
                    @endif
                  @else
                    <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa()"><b>Registrar Cambios</b></a>
                  @endif
                </div>
              </div>
          </div>
      </div>
        <div class="text-center">
          <br>
          <a class="btn btn-primary btn-lg" role="button" href="{{url('detalleProducto', [$producto->idProducto])}}"><b>Volver</b></a>
        </div>
    </div>
    <div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="Opciones disponibles" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Opciones Disponibles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" align="center">
            <h5>
              Cantidad de Pausas:
              <br>
              <b>{{$producto->cantPausa}}</b>
            </h5>
            <br>
          @if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0))
            @foreach($pausas_almacenadas as $key => $pausa)
              @if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin == NULL))
                    <h5>
                      Pausa Pendiente
                      <br>
                      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" href="{{url('trabajadorDetallesPausaGet', [$pausa->idPausa])}}">Ver Pausa {{$producto->cantPausa}}</a>
                      <br>
                    </h5>
                  </div>
                </div>
                @break
              @endif
            @endforeach
          @endif
        </div>
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


function savePausa()
    {
      var datosPausa, json_text;

      datosPausa = Array();
      datosPausa[0] = {{$producto->idProducto}};
      datosPausa[1] = document.getElementById("descripcion").value;
      datosPausa[2] = document.getElementById("fechaInicio").value;
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
