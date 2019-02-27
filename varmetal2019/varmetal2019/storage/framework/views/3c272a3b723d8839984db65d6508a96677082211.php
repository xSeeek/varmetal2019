<?php $__env->startSection('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!--style>
    div.texto {
        display: flex;
        justify-content: center;
    }
  </style-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                        <input id="nombreProducto" value="<?php echo e($producto->nombre); ?>" type="text" class="form-control" aria-describedby="nombreProducto" placeholder="Nombre del Producto" name="nombreProducto" readonly=”readonly”>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Codigo del Producto:</b></label>
                        <div class="col-md-6">
                          <input id="idProducto" value="<?php echo e($producto->codigo); ?>" type="text" class="form-control" aria-describedby="idProducto" placeholder="Id del Producto" name="idProducto" readonly=”readonly”>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right"><b>Hora Inicio Pausa:</b></label>
                        <div class="col-md-6">
                          <input id="fechaInicio" value="<?php echo e($fechaInicio); ?>" type="timestamp" class="form-control" name="fechaInicio" readonly=”readonly”>
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
                  <?php if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0)): ?>
                    <?php if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin == NULL)): ?>
                      <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick=""><b>Posee una Pausa Pendiente</b></a>
                    <?php else: ?>
                      <?php if(($pausas_almacenadas->last()->producto_id_producto == $producto->idProducto) && ($pausas_almacenadas->last()->fechaFin != NULL)): ?>
                        <?php if($producto->cantPausa<=14): ?>
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa(<?php echo e($producto->cantPausa); ?>)"><b>Registrar Cambios</b></a>
                        <?php endif; ?>
                      <?php else: ?>
                          <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick=""><b>Limite de Pausas alcanzado</b></a>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php else: ?>
                    <a class="btn btn-outline-success my-1 my-sm-0" role="button" onclick="savePausa()"><b>Registrar Cambios</b></a>
                  <?php endif; ?>
                </div>
              </div>
          </div>
      </div>
        <div class="text-center">
          <br>
          <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('detalleProducto', [$producto->idProducto])); ?>"><b>Volver</b></a>
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
              <b><?php echo e($producto->cantPausa); ?></b>
            </h5>
            <br>
          <?php if(($pausas_almacenadas!=NULL) && (count($pausas_almacenadas)>0)): ?>
            <?php $__currentLoopData = $pausas_almacenadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pausa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(($pausa->producto_id_producto == $producto->idProducto) && ($pausa->fechaFin == NULL)): ?>
                    <h5>
                      Pausa Pendiente
                      <br>
                      <a class="btn btn-outline-success btn-md" id="finPausa" role="button" href="<?php echo e(url('trabajadorDetallesPausaGet', [$pausa->idPausa])); ?>">Ver Pausa <?php echo e($producto->cantPausa); ?></a>
                      <br>
                    </h5>
                  </div>
                </div>
                <?php break; ?>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
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
      datosPausa[0] = <?php echo e($producto->idProducto); ?>;
      datosPausa[1] = document.getElementById("descripcion").value;
      datosPausa[2] = document.getElementById("fechaInicio").value;
      json_text = JSON.stringify(datosPausa);
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "<?php echo e(url('/SuperPausaControl')); ?>",
          success: function(response){
              if(response!='Datos almacenados')
              {
                  alert(response);
                  console.log(response);
              }
              else
                  window.location.href="<?php echo e(url('/addPausa', [$producto->idProducto])); ?>";
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
            url: "<?php echo e(url('/trabajadorUpdateFechaFinPost')); ?>",
            success: function(response){
                console.log(response);
                window.location.href = "<?php echo e(url('/addPausa', [$producto->idProducto])); ?>";
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>