<?php $__env->startSection('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalle del producto
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i></button>
                </div>
                <div class="card-body">
                    <h5>
                        <b>Código del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="codigoProducto" class="form-control-plaintext" value="<?php echo e($producto->codigo); ?>">
                        </div>
                        <b>Nombre del Producto:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="nombreProducto" class="form-control-plaintext" value="<?php echo e($producto->nombre); ?>">
                        </div>
                        <b>Fecha de Inicio de Desarrollo:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="fechaInicioProducto" class="form-control-plaintext" value="<?php echo e($producto->fechaInicio); ?>">
                        </div>
                        <b>Fecha de Finalización de Desarrollo:</b>
                        <div class="col-sm-10">
                            <?php if($producto->fechaFin == NULL): ?>
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="Aún no se finaliza">
                            <?php else: ?>
                                <input type="text" readonly id="fechaFinProducto" class="form-control-plaintext" value="<?php echo e($producto->fechaFin); ?>">
                            <?php endif; ?>
                        </div>
                        <b>Peso unitario(en Kilogramos):</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="pesoProducto" class="form-control-plaintext" value="<?php echo e($producto->pesoKg); ?> Kg">
                        </div>
                        <b>Obra:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="obraProducto" class="form-control-plaintext" value="<?php echo e($obra->nombre); ?>">
                        </div>
                        <b>Estado Actual:</b>
                        <div class="col-sm-10">
                            <?php switch($producto->estado):
                                case (0): ?>
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Por realizar">
                                    <?php break; ?>
                                <?php case (1): ?>
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Finalizado">
                                    <?php break; ?>
                                <?php case (2): ?>
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="En proceso de desarrollo">
                                    <?php break; ?>
                                <?php default: ?>
                                    <input type="text" readonly id="estadoProducto" class="form-control-plaintext" value="Sin estado definido">
                                    <?php break; ?>
                            <?php endswitch; ?>
                        </div>
                        <b>Cantidad realizada:</b>
                        <div class="col-sm-10">
                            <input type="text" readonly id="cantidadProducto" class="form-control-plaintext" value="<?php echo e($cantidadProducida); ?>/<?php echo e($producto->cantProducto); ?>">
                        </div>
                        <b>Prioridad:</b>
                        <div class="col-sm-10">
                            <?php switch($producto->prioridad):
                                case (1): ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Baja">
                                    <?php break; ?>
                                <?php case (2): ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Baja">
                                    <?php break; ?>
                                <?php case (3): ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media">
                                    <?php break; ?>
                                <?php case (4): ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Media Alta">
                                    <?php break; ?>
                                <?php case (5): ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Alta">
                                    <?php break; ?>
                                <?php default: ?>
                                    <input type="text" readonly id="prioridadProducto" class="form-control-plaintext" value="Sin prioridad">
                                    <?php break; ?>
                            <?php endswitch; ?>
                        </div>
                    </h5>
                </div>
                <?php if($cantidadProducida != $producto->cantProducto): ?>
                    <a class="btn btn-outline-primary btn-lg" role="button" onclick="actualizarCantidad(<?php echo e($producto->idProducto); ?>)"><b>Actualizar cantidad producida</b></a>
                <?php endif; ?>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Trabajadores activos</div>
                <div class="card-body">

                <?php if(($trabajadores != NULL) && (count($trabajadores)>0)): ?>
                <table id="tablaAdministracion" style="width:100%" align="center">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="id_Trabajador<?php echo e($trabajador->idTrabajador); ?>">
                            <td scope="col"><?php echo e($trabajador->rut); ?></td>
                            <td scope="col"><?php echo e($trabajador->nombre); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php else: ?>
                <br>
                    <h4 align="center">No hay trabajadores asignados.</h4>
                <br>
                <?php endif; ?>
                </div>
            </div>
        <br>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('adminTrabajador')); ?>"><b>Volver</b></a>
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
              <?php if($producto->fechaFin == NULL): ?>
                <h5>
                    Solicitar Pausa:
                <br>
                      <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="<?php echo e(url('addPausa', [$producto->idProducto])); ?>">Pausar</a>
                </h5>
              <?php endif; ?>
                <br>
                <?php if($producto->terminado == false): ?>
                    <?php if($producto->estado == 2): ?>
                        <?php if($cantidadProducida == $producto->cantProducto): ?>
                            <h5>
                                Marcar como terminado:
                            <br>
                                <a class="btn btn-outline-warning btn-md" id="stopButton" role="button" onclick="markAsFinished(<?php echo e($producto->idProducto); ?>)">Terminar</a>
                            </h5>
                        <?php endif; ?>
                    <?php else: ?>
                        <h5>
                            Anular termino:
                        <br>
                            <a class="btn btn-outline-danger btn-md" id="stopButton" role="button" onclick="unmarkAsFinished(<?php echo e($producto->idProducto); ?>)">Anular</a>
                        </h5>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function markAsFinished(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "<?php echo e(url('producto/Finalizar')); ?>",
            success: function(response){
                if(response == 1)
                    window.location.href = "<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>";
                else {
                    alert(response);
                }
            }
        });
    }
    function unmarkAsFinished(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "<?php echo e(url('producto/Anular')); ?>",
            success: function(response){
                if(response == 1)
                    window.location.href = "<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>";
                else {
                        alert(response);
                    }
            }
        });
    }
    function actualizarCantidad(idProducto)
    {
        if (confirm("Presione OK para actualizar la cantidad"))
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {DATA:idProducto},
                url: "<?php echo e(url('producto/actualizarCantidad')); ?>",
                success: function(response){
                    if(response == 1)
                        window.location.href = "<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>";
                    else {
                            alert(response);
                        }
                }
            });
        }
        else
            return;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>