<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajadores</div>
                    <div class="card=body container mt-3">
                        <?php if(($trabajadores_almacenados != NULL) && (count($trabajadores_almacenados) > 0)): ?>
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $trabajadores_almacenados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="id_trabajador<?php echo e($trabajador->idTrabajador); ?>">
                                    <td scope="col"><?php echo e($trabajador->rut); ?></td>
                                    <td scope="col"><?php echo e($trabajador->nombre); ?></td>
                                    <?php if($trabajador->estado == 1): ?>
                                        <td scope="col">Activo</td>
                                    <?php else: ?>
                                        <td scope="col">Inactivo</td>
                                    <?php endif; ?>
                                    <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('trabajadorControl', [$trabajador->idTrabajador])); ?>" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No hay trabajadores registrados en el sistema</h4>
                        <br>
                        <?php endif; ?>
                    </div>
                </br>
                <a class="btn btn-outline-success btn-lg" align="right" role="button" href="<?php echo e(url('/addTrabajador')); ?>"><b>Agregar Trabajador</b></a>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('admin')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>