<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos</div>
                    <div class="card=body container mt-3">
                        <?php if(($productos != NULL) && (count($productos) > 0)): ?>
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Peso (Kg)</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="id_producto<?php echo e($producto->idProducto); ?>">
                                    <td scope="col"><?php echo e($producto->nombre); ?></td>
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
                                    <?php switch($producto->estado):
                                        case (0): ?>
                                            <td scope="col">Por realizar</th>
                                            <?php break; ?>
                                        <?php case (1): ?>
                                            <td scope="col">Finalizado</th>
                                            <?php break; ?>
                                        <?php case (2): ?>
                                            <td scope="col">En realización</th>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <td scope="col">Sin estado definido</th>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                    <td scope="col"><?php echo e($producto->cantProducto); ?></td>
                                    <td scope="col"><?php echo e($producto->pesoKg); ?></td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('productoControl', [$producto->idProducto])); ?>" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No existen productos registrados en el sistema</h4>
                        <br>
                        <?php endif; ?>
                    </div>
                <br>
                <a class="btn btn-outline-success btn-lg" align="right" role="button" href="<?php echo e(url('/addProducto')); ?>"><b>Agregar Producto</b></a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('admin')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>