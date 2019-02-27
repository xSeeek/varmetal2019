<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pausas</div>
                    <div class="card=body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Filtro</label>
                            </div>
                            <input class="form-control" type="text" id="inputPausa" onkeyup="filterPausa()" placeholder="Ingrese el ID de la Pausa" title="ID Pausa">
                        </div>
                        <?php if(($pausas_almacenadas != NULL) && (count($pausas_almacenadas) > 0)): ?>
                        <table id="tablaAdministracion" style="width:90%; margin:20px;" align="center">
                            <tr>
                                <th>ID Pausa</th>
                                <th>ID Producto</th>
                                <th>Nombre Producto</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                            </tr>
                            <?php $__currentLoopData = $pausas_almacenadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pausa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($pausa->producto_id_producto == $producto->idProducto): ?>
                                  <tr id="id_pausa<?php echo e($pausa->idPausa); ?>">
                                      <td scope="col"><?php echo e($pausa->idPausa); ?></td>
                                      <td scope="col"><?php echo e($producto->idProducto); ?></td>
                                      <td scope="col"><?php echo e($producto->nombre); ?></td>
                                      <td scope="col"><?php echo e($pausa->fechaInicio); ?></td>
                                      <?php if($pausa->fechaFin!=NULL): ?>
                                        <td scope="col"><?php echo e($pausa->fechaFin); ?></td>
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo e(url('adminDetallesPausaGet', [$pausa->idPausa])); ?>" role="button" style="cursor: pointer;">Ver Detalles</a></td>
                                      <?php else: ?>
                                        <td scope="col">Pendiente</d>
                                        <td><a class="btn btn-outline-success my-2 my-sm-0" onclick="" role="button" style="cursor: pointer;">No Disponible</a></td>
                                      <?php endif; ?>
                                  </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                        <?php else: ?>
                        <br>
                            <h4 align="center">No hay pausas registradas en este Producto</h4>
                        <br>
                        <?php endif; ?>
                    </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('admin')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function filterPausa()
    {
        var input, table, tr, tdYear, i;
        inputID = document.getElementById("inputPausa").value;
        table = document.getElementById("tablaAdministracion");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++)
        {
            tdYear = tr[i].getElementsByTagName("td")[0];
            if(tdYear)
            {
                if ((tdYear.innerHTML.indexOf(inputID) > -1))
                    tr[i].style.display = "";
                else
                    tr[i].style.display = "none";
            }
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>