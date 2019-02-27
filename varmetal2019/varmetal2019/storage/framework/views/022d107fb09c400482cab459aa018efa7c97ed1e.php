<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos</div>
                    <div class="card=body container mt-3">
                        <?php if(($obras != NULL) && (count($obras) > 0)): ?>
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $obras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $obra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="id_obra<?php echo e($obra->idObra); ?>">
                                    <td scope="col"><?php echo e($obra->nombre); ?></td>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('obraControl', [$obra->idObra])); ?>" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No existen obras registrados en el sistema</h4>
                        <br>
                        <?php endif; ?>
                    </div>
                <br>
                <a class="btn btn-outline-success btn-lg" align="right" role="button" href="<?php echo e(url('/addObra')); ?>"><b>Agregar Obra</b></a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('admin')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>