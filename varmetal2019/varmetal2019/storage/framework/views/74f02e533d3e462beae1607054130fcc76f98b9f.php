<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos en desarrollo</div>
                    <div class="card-body">
                        <?php $cont = 0 ?>
                        <?php if(($productos != NULL) && (count($productos) > 0)): ?>
                            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($producto->terminado == true): ?>
                                    <?php $cont++ ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($cont == count($productos)): ?>
                                <h4 align="center">No tiene productos activos en desarrollo</h4>
                            <?php else: ?>
                                <table id="tablaAdministracion" style="width:100%" align="center">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Peso (Kg)</th>
                                            <th>Estado</th>
                                            <th>Prioridad</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($producto->terminado == false): ?>
                                            <?php $cont++ ?>
                                            <tr id="id_producto<?php echo e($producto->idProducto); ?>">
                                                <td scope="col"><?php echo e($producto->nombre); ?></td>
                                                <td scope="col"><?php echo e($producto->pesoKg); ?></td>
                                                <?php switch($producto->estado):
                                                    case (0): ?>
                                                        <td scope="col">Por realizar</th>
                                                        <?php break; ?>
                                                    <?php case (1): ?>
                                                        <td scope="col">Finalizado</th>
                                                        <?php break; ?>
                                                    <?php case (2): ?>
                                                        <td scope="col">En proceso de desarrollo</th>
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <td scope="col">Sin estado definido</th>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                                <?php switch($producto->prioridad):
                                                    case (1): ?>
                                                        <td scope="col">Baja</td>
                                                        <?php break; ?>
                                                    <?php case (2): ?>
                                                        <td scope="col">Media Baja</td>
                                                        <?php break; ?>
                                                    <?php case (3): ?>
                                                        <td scope="col">Media</td>
                                                        <?php break; ?>
                                                    <?php case (4): ?>
                                                        <td scope="col">Media Alta</td>
                                                        <?php break; ?>
                                                    <?php case (5): ?>
                                                        <td scope="col">Alta</td>
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <td scope="col">Sin prioridad</td>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                                <?php if($producto->pivot->fechaComienzo != NULL): ?>
                                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                                <?php else: ?>
                                                    <td><a class="btn btn-outline-success my-2 my-sm-0" onclick="updateDate(<?php echo e($producto->idProducto); ?>, '<?php echo e(url('/detalleProducto', [$producto->idProducto])); ?>')" role="button" style="cursor: pointer;">Iniciar Producción</a></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No tiene productos activos en desarrollo</h4>
                        <br>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function updateDate(idProducto, ruta)
    {
        if (confirm("Presione OK para comenzar con el desarrollo del producto"))
        {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:idProducto},
            url: "<?php echo e(url('/trabajadorControl/setStartTime')); ?>",
            success: function(response){
                window.location.href = ruta;
            }
        });
        }
        else
            return;
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>