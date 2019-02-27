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
                        <?php if($producto->estado == 1 && $producto->terminado == false): ?>
                            <br>
                            <b style="color:red">Información Importante:</b>
                            <div class="col-sm-10">
                                <input type="text" readonly id="pesoProducto" style="color:red" class="form-control-plaintext" value="Este producto se marcó como terminado.">
                            </div>
                        <?php endif; ?>
                    </h5>
                </div>
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
                            <th>Cargo</th>
                            <th>Kg realizados</th>
                            <th>Estado</th>
                            <th>Ficha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="id_Trabajador<?php echo e($trabajador->idTrabajador); ?>">
                            <td scope="col"><?php echo e($trabajador->rut); ?></td>
                            <td scope="col"><?php echo e($trabajador->nombre); ?></td>
                            <td scope="col"><?php echo e($trabajador->cargo); ?></td>
                            <td scope="col"><?php echo e($trabajador->pivot->kilosTrabajados); ?></td>
                            <?php if($trabajador->pivot->fechaComienzo == NULL): ?>
                                <td scope="col">Aún no inicia</td>
                            <?php else: ?>
                                <td scope="col">Inició el desarrollo</td>
                            <?php endif; ?>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" href="<?php echo e(url('trabajadorControl', [$trabajador->idTrabajador])); ?>" role="button"><b>Ficha Trabajador</b></a>
                            <td scope="col"><a class="btn btn-outline-secondary btn-sm" onclick="deleteWorker(<?php echo e($trabajador->idTrabajador); ?>, <?php echo e($producto->idProducto); ?>)" role="button"><b>Eliminar</b></a>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php else: ?>
                </br>
                    <h4 align="center">No hay trabajadores asignados.</h4>
                </br>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('adminProducto')); ?>"><b>Volver</b></a>
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
                    Ver Pausas:
                </br>
                    <a class="btn btn-outline-success btn-md" id="pauseButton" role="button" href="<?php echo e(url('adminPausasAlmacenadas', [$producto->idProducto])); ?>">Pausas</a>
                </h5>
                <br>
                <h5>
                    Eliminar Producto:
                </br>
                    <a class="btn btn-outline-success btn-md" id="deleteButton" role="button" onclick="deleteProducto(<?php echo e($producto->idProducto); ?>)">Eliminar</a>
                </h5>
                <br>
                <h5>
                    Asignar más trabajadores:
                </br>
                    <a class="btn btn-outline-success btn-md" id="insertButton" role="button" href="<?php echo e(url('producto/asignarTrabajo', [$producto->idProducto])); ?>">Asignar</a>
                </h5>
                <?php if($producto->terminado == false): ?>
                    <?php if($producto->estado == 1): ?>
                        <br>
                        <h5>
                            Anular Termino:
                        </br>
                            <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProduccion(<?php echo e($producto->idProducto); ?>)">Reiniciar</a>
                        </h5>
                        <br>
                        <h5>
                            Terminar Producto:
                        </br>
                            <a class="btn btn-outline-danger btn-md" id="finishButton" role="button" onclick="finishProduccion(<?php echo e($producto->idProducto); ?>)">Terminar</a>
                        </h5>
                    <?php endif; ?>
                <?php else: ?>
                    <br>
                    <h5>
                        Reiniciar Producto:
                    </br>
                        <a class="btn btn-warning btn-md" id="resetButton" role="button" onclick="resetProducto(<?php echo e($producto->idProducto); ?>)">Reiniciar</a>
                    </h5>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteProducto(data)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:data},
            url: "<?php echo e(url('/productoControl/deleteProducto')); ?>",
            success: function(response){
                window.location.href = response.redirect;
            }
        });
    }
    function deleteWorker(idTrabajador, idProducto)
    {
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
            url: "<?php echo e(url('/productoControl/removeWorker')); ?>",
            success: function(response){
                window.location.href = "<?php echo e(url('productoControl', [$producto->idProducto])); ?>";
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
            url: "<?php echo e(url('/productoControl/resetProduccion')); ?>",
            success: function(response){
                window.location.href = "<?php echo e(url('productoControl', [$producto->idProducto])); ?>";
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
            url: "<?php echo e(url('/productoControl/finishProduccion')); ?>",
            success: function(response){
                if(response == 1)
                    window.location.href = "<?php echo e(url('productoControl', [$producto->idProducto])); ?>";
                else
                    alert(response);
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
            url: "<?php echo e(url('/productoControl/resetProducto')); ?>",
            success: function(response){
                window.location.href = "<?php echo e(url('productoControl', [$producto->idProducto])); ?>";
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>