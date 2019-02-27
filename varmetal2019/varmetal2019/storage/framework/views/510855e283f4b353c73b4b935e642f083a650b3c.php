<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trabajadores</div>
                    <div class="card=body">
                        <div class="container mt-3">
                            <?php if(($trabajadores_almacenados != NULL) && (count($trabajadores_almacenados) > 0)): ?>
                            <table id="tablaAdministracion" style="width:100%" align="center">
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $trabajadores_almacenados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="id_trabajador<?php echo e($trabajador->idTrabajador); ?>">
                                        <td scope="col"><button class="btn btn-success" onclick="asignarTrabajo(<?php echo e($idProducto); ?>, <?php echo e($trabajador->idTrabajador); ?>)"><i class="far fa-check-square success"></i></button></td>
                                        <td scope="col"><?php echo e($trabajador->rut); ?></td>
                                        <td scope="col"><?php echo e($trabajador->nombre); ?></td>
                                        <?php if($trabajador->estado == 1): ?>
                                            <td scope="col">Activo</td>
                                        <?php else: ?>
                                            <td scope="col">Inactivo</td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <br>
                                <h4 align="center">No hay trabajadores registrados en el sistema</h4>
                            <br>
                            <?php endif; ?>
                            <br>
                        </div>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('productoControl', [$idProducto])); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function asignarTrabajo(idProducto, idTrabajador)
    {
        var datosWorker, json_data;

        datosWorker = Array();
        datosWorker[0] = idProducto;
        datosWorker[1] = idTrabajador;

        json_data = JSON.stringify(datosWorker);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {DATA:json_data},
            url: "<?php echo e(url('/productoControl/addWorker')); ?>",
            success: function(response){
                if(response == 1)
                    window.location.href = "<?php echo e(url('producto/asignarTrabajo', [$idProducto])); ?>";
                else
                    alert('Error al asignar al trabajador');
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>