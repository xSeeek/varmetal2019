<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Productos Disponibles
                </div>
                <div class="card=body">
                    <div class="container mt-3">
                        <?php if(($productos_almacenados != NULL) && (count($productos_almacenados) > 0)): ?>
                        <table id="tablaAdministracion" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th>Opción</th>
                                    <th>Nombre</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Peso total (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $productos_almacenados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="id_trabajador<?php echo e($producto->idProducto); ?>">
                                    <td scope="col"><button class="btn btn-success" onclick="asignarTrabajo(<?php echo e($idTrabajador); ?>, <?php echo e($producto->idProducto); ?>)"><i class="far fa-check-square success"></i></button></td>
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
                                            <td scope="col">En proceso de desarrollo</th>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <td scope="col">Sin estado definido</th>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                    <td scope="col"><?php echo e($producto->cantProducto); ?></td>
                                    <td scope="col"><?php echo e($producto->pesoKg); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No hay productos disponibles</h4>
                        <br>
                        <?php endif; ?>
                        <br>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('trabajadorControl', [$idTrabajador])); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function asignarTrabajo(idTrabajador, idProducto)
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
                    window.location.href = "<?php echo e(url('trabajador/asignarProducto', [$idTrabajador])); ?>";
                else
                    alert('Error al asignar el producto');
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>