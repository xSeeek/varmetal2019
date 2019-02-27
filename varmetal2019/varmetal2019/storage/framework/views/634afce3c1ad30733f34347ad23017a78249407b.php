<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administracion</div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    Bienvenido, </br>
                    Correo actual: <?php echo Auth::user()->email?>
                </div>
            </div>
            </br>
            <div class="card">
                <div class="card-header">Administracion</div>
                <div class="card=body container mt-3">
                    <table id="tablaAdministracion" style="width:50%; margin:15px;">
                        <tr>
                            <th>Productos</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('adminProducto')); ?>" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        <tr>
                            <th>Trabajadores</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('adminTrabajador')); ?>" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        <tr>
                            <th>Pausas</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('adminPausas')); ?>" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                        <tr>
                            <th>Obras</th>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('adminObras')); ?>" role="button" style="cursor: pointer;">Ingresar</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>