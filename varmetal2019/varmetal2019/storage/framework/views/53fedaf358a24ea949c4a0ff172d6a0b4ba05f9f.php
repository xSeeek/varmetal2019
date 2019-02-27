<?php $__env->startSection('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nuevo trabajador</div>
                <div class="card-body">
                    <form method="POST" name="nuevoTrabajadorForm" id="nuevoTrabajadorForm">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Usuario')); ?></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" aria-describedby="email" placeholder="Email del Trabajador" name="email" value="<?php echo e(old('email')); ?>" required>
                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row" id="passwordForm">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Contraseña')); ?></label>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <input class="form-control" id="password" type="text" aria-describedby="password" placeholder="Contraseña del Trabajador" name="password" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="generarPassword()" type="button">Generar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre completo del Trabajador:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="nameTrabajador" placeholder="Nombre del Trabajador" name="nameTrabajador" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">RUT del Trabajador:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="rut" aria-describedby="rutTrabajador" placeholder="RUT del Trabajador" name="rutTrabajador" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Tipo:</label>
                            <div class="col-md-6">
                                <select class="custom-select" id="inputType" aria-describedby="inputType" name="type" required>
                                        <option value="1">Supervisor</option>
                                        <option selected value="0">Trabajador</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <button class="btn btn-primary mb-2" id='saveTrabajador' onclick="saveTrabajador()">Registrar Cambios</a>
                    </div>
                </div>
            </div>
        </br>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo e(url('adminTrabajador')); ?>"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input#rut").rut({formatOn: 'keyup', ignoreControlKeys: false});
    });
    function saveTrabajador()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoTrabajadorForm').serialize(),
            url: "<?php echo e(url('trabajadorControl/addTrabajador')); ?>",
            success: function(response){
                if(response != 1)
                {
                    alert(response);
                    console.log(response);
                }
                else
                    window.location.href = "<?php echo e(url('adminTrabajador')); ?>";
            }
        });
    }
    function validateStatus()
    {
        var hiddenStatus;
        hiddenStatus = document.getElementById("verifyUser").value;
        if(hiddenStatus == 1)
        {
            document.getElementById("statusUser").value = 1;
            document.getElementById("passwordForm").hidden = true;
            return;
        }
        document.getElementById("statusUser").value = 0;
        document.getElementById("passwordForm").hidden = false;
        return;
    }
    function generarPassword()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "<?php echo e(route('admin.createPassword')); ?>",
            success: function (response) {
                $('#password').attr('value', response);
            },
            error: function (response) {
                alert('Ocurrio un error inesperado, contacte con el soporte técnico')
            }
        });
    }
    window.onload = generarPassword;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>