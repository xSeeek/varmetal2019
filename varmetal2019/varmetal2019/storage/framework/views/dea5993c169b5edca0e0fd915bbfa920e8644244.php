<?php $__env->startSection('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  Detalle de la Pausa
                  <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Fecha de Inicio:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicioPausa" class="form-control-plaintext" value="<?php echo e($pausa->fechaInicio); ?>" readonly="readonly">
                        </div>
                        <b>Fecha de Finalización:</b>
                        <div class="col-sm-10">
                            <?php if($pausa->fechaFin == NULL): ?>
                                <input type="text" readonly id="fechaFinPausa" class="form-control-plaintext" value="Pausa pendiente">
                            <?php else: ?>
                                <input type="text" readonly id="fechaFinPausa" class="form-control-plaintext" value="<?php echo e($pausa->fechaFin); ?>" readonly="readonly">
                            <?php endif; ?>
                        </div>
                        <b>Nombre del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="<?php echo e($producto->nombre); ?>" readonly="readonly">
                        </div>
                        <b>ID del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="codigo" class="form-control-plaintext" value="<?php echo e($producto->codigo); ?>" readonly="readonly">
                        </div>
                        <b>Nombre del Trabajador:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreTrabajador" class="form-control-plaintext" value="<?php echo e($trabajador->nombre); ?>">
                        </div>
                        <?php if($pausa->fechaFin == NULL): ?>
                          <b>Descripcion: (Editable)</b>
                        <?php else: ?>
                          <b>Descripcion:</b>
                        <?php endif; ?>
                        <div class="col-sm-10">
                          <?php if($pausa->fechaFin == NULL): ?>
                            <input type="text" id="descripcion" class="form-control-plaintext" value="<?php echo e($pausa->descripcion); ?>">
                          <?php else: ?>
                            <input type="text" readonly id="descripcion" class="form-control-plaintext" value="<?php echo e($pausa->descripcion); ?>">
                          <?php endif; ?>
                        </div>
                    </h5>
                </div>
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
                    <?php if($pausa->fechaFin==NULL): ?>
                        <?php if($usuarioActual->type == 'Admin'): ?>
                          <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="sendEmail()" onclick="adminUpdateFechaFin(<?php echo e($pausa->idPausa); ?>)">Finalizar Pausa</a>
                          <br><br>
                          <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="adminDeletePausa(<?php echo e($pausa->idPausa); ?>)">Eliminar Pausa</a>

                        <?php else: ?>
                          <?php if(($producto->cantPausa==5) || ($producto->cantPausa==10) || ($producto->cantPausa==15)): ?>
                            <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="sendEmail()">Finalizar Pausa</a>
                          <?php else: ?>
                            <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="trabajadorUpdateFechaFin()">Finalizar Pausa</a>
                          <?php endif; ?>
                            <br><br>
                            <a class="btn btn-outline-success btn-md" id="finPausa" role="button" onclick="trabajadorDeletePausa(<?php echo e($pausa->idPausa); ?>)">Eliminar Pausa</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <b>Pausa Finalizada</b>
                    <?php endif; ?>
                    <br><hr>
                    <?php if($usuarioActual->type == 'Admin'): ?>
                      <a class="btn btn-outline-success btn-md" id="detallesTrabajador" role="button" href="<?php echo e(url('/trabajadorControl', [$trabajador->idTrabajador])); ?>">Ver Trabajador</a>
                      <br><br>
                      <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="<?php echo e(url('/productoControl', [$producto->idProducto])); ?>">Ver Producto</a>
                      <br><br>
                    <?php else: ?>
                      <a class="btn btn-outline-success btn-md" id="detallesProducto" role="button" href="<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>">Ver Producto</a>
                      <br><br>
                    <?php endif; ?>
                </h5>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
    </br>
    <div class="row justify-content-center">
            <?php if($usuarioActual->type=='Admin'): ?>
              <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('/adminPausas')); ?>"><b>Volver</b></a>
            <?php else: ?>
              <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('addPausa', [$producto->idProducto])); ?>"><b>Volver</b></a>
            <?php endif; ?>
    </div>
</div>
<script>
  function trabajadorDeletePausa()
  {
    var datos, json_text;

    datos = Array();
    datos[0] = <?php echo e($pausa->idPausa); ?>;
    datos[1] = <?php echo e($producto->idProducto); ?>;
    json_text = JSON.stringify(datos);

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "<?php echo e(url('/trabajadorDeletePausa')); ?>",
          success: function(response){
              console.log(response);
              window.location.href = "<?php echo e(url('/addPausa', [$producto->idProducto])); ?>";
          }
      });
  }
  function adminDeletePausa(data)
  {
    var datos, json_text;

    datos = Array();
    datos[0] = <?php echo e($pausa->idPausa); ?>;
    datos[1] = <?php echo e($producto->idProducto); ?>;
    json_text = JSON.stringify(datos);

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:json_text},
          url: "<?php echo e(url('/adminDeletePausa')); ?>",
          success: function(response){
              console.log(response);
              window.location.href = "<?php echo e(url('/adminPausasAlmacenadas', [$producto->idProducto])); ?>";
          }
      });
  }

  function adminUpdateFechaFin(data)
  {
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {DATA:data},
          url: "<?php echo e(url('/adminUpdateFechaFinPost')); ?>",
          success: function(response){
              console.log(response);
              window.location.href = "<?php echo e(url('/adminDetallesPausaGet', [$pausa->idPausa])); ?>";
          }
      });
  }

  function sendEmail()
      {
        var datosPausa, json_text;

        datosPausa = Array();
        datosPausa[0] = '<?php echo e($trabajador->nombre); ?>';
        datosPausa[1] = '<?php echo e($trabajador->rut); ?>';
        datosPausa[2] = '<?php echo e($usuarioActual->email); ?>';
        json_text = JSON.stringify(datosPausa);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_text},
            url: "<?php echo e(url('/enviarEmail')); ?>",
            success: function(response){
                if(response!='Email enviado')
                {
                    alert(response);
                    console.log(response);
                }
                else
                    //window.location.href="<?php echo e(url('/trabajadorDetallesPausaGet', [$pausa->idPausa])); ?>";
                    trabajadorUpdateFechaFin();
          }
        });
      }

    function trabajadorUpdateFechaFin()
      {

        var datosPausa, json_text;

        datosPausa = Array();
        datosPausa[0] = <?php echo e($pausa->idPausa); ?>;
        datosPausa[1] = document.getElementById("descripcion").value;
        json_text = JSON.stringify(datosPausa);
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              data: {DATA:json_text},
              url: "<?php echo e(url('trabajadorUpdateFechaFinPost')); ?>",
              success: function(response){
                  console.log(response);
                  window.location.href = "<?php echo e(url('/trabajadorDetallesPausaGet', [$pausa->idPausa])); ?>";
              }
          });
      }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>