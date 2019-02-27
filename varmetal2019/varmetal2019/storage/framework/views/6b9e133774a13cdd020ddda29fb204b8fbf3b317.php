<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajador</div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    Bienvenido, <?php echo e($trabajador->nombre); ?>. <br><br>
                    Correo actual: <?php echo e($user->email); ?> <br><br>
                    Rut: <?php echo e($trabajador->rut); ?> <br><br>
                    Cargo: <?php echo e($trabajador->cargo); ?> <br><br>
                </div>
            </div>
            </br>
            <div class="card">
                <div class="card-heade row justify-content-center">Sus Productos</div>
                            <a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('/productosTrabajador')); ?>" role="button" style="cursor: pointer;">Ingresar</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>