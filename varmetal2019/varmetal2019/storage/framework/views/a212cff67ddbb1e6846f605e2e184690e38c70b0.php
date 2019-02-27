<?php $__env->startSection('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo producto</div>
                <div class="card-body">
                    <form method="POST" name="nuevoProductoForm" id="nuevoProductoForm">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Código del Producto:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="codigoProducto" placeholder="Código del Producto" name="codigoProducto" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre del Producto:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="nombreProducto" placeholder="Nombre del Producto" name="nombreProducto" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Fecha Inicio</label>
                            <div class='col-sm-6'>
                                <input class="form-control" type="datetime-local" id="fechaInicio" name="fechaInicio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Peso unitario del producto (en Kilogramos):</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="pesoProducto" placeholder="Peso del Producto" name="pesoProducto" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Cantidad:</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" aria-describedby="cantidadProducto" placeholder="Cantidad del Producto" name="cantidadProducto" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Obra:</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <select class="custom-select" id="inputObra" aria-describedby="obraProducto" name="obraProducto" required>
                                        <option selected disabled>Seleccione una obra...</option>
                                        <?php if(($obras != NULL) && (count($obras)>0)): ?>
                                            <?php $__currentLoopData = $obras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obra->idObra); ?>"><?php echo e($obra->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Prioridad:</label>
                            <div class="col-md-6">
                                <select class="custom-select" id="inputPrioridad" aria-describedby="inputPrioridad" name="inputPrioridad" required>
                                        <option value="1">Baja</option>
                                        <option value="2">Media Baja</option>
                                        <option selected value="3">Media</option>
                                        <option value="4">Media Alta</option>
                                        <option value="5">Alta</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <button class="btn btn-primary mb-2" id='saveProducto' onclick="saveProducto()">Registrar Cambios</a>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('adminProducto')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function saveProducto()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoProductoForm').serialize(),
            url: "<?php echo e(url('productoControl/addProducto')); ?>",
            success: function(response){
                if(response != 1)
                {
                    alert(response);
                    console.log(response);
                }
                else
                    window.location.href = "<?php echo e(url('adminProducto')); ?>";
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>