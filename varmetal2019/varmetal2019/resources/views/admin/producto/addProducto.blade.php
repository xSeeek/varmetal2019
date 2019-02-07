@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar nueva Pieza</div>
                <div class="card-body">
                    <form method="POST" name="nuevoProductoForm" id="nuevoProductoForm">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Código de la Pieza:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-describedby="codigoProducto" placeholder="Código del Producto" name="codigoProducto" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Descripcion:</label>
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
                            <label class="col-md-4 col-form-label text-md-right">Peso unitario de la Pieza (en Kilogramos):</label>
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
                            <label class="col-md-4 col-form-label text-md-right">OT a la cual pertenece:</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <select class="form-control selectpicker" data-live-search="true" id="inputObra" aria-describedby="obraProducto" name="obraProducto" required>
                                        <option selected disabled>Seleccione una obra...</option>
                                        @if(($obras != NULL) && (count($obras)>0))
                                            @foreach($obras as $obra)
                                                <option value="{{$obra->idObra}}">{{$obra->codigo}} - {{$obra->proyecto}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Tipo:</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <select class="custom-select" id="tipoObra" aria-describedby="tipoProducto" name="tipoProducto" required>
                                        <option selected disabled>Seleccione un tipo...</option>
                                        @if(($tipos != NULL) && (count($tipos)>0))
                                            @foreach($tipos as $tipo)
                                                <option value="{{$tipo->idTipo}}">{{$tipo->nombreTipo}}</option>
                                            @endforeach
                                        @endif
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
            <a class="btn btn-primary btn-lg" role="button" href="{{url('menuPiezas')}}"><b>Volver</b></a>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function()
    {
        $('.selectpicker').selectpicker();
    });

    function saveProducto()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $('#nuevoProductoForm').serialize(),
            url: "{{url('productoControl/addProducto')}}",
            success: function(response){
                if(response != 1)
                    showMensajeSwal(MSG_ERROR, BTN_ERROR, COLOR_ERROR,response);
                else
                {
                    showMensajeSwal(MSG_SUCCESS, BTN_SUCCESS, COLOR_SUCCESS,"Se agrego Correctamente");
                    window.location.reload();
                }
            }
        });
    }

</script>
@endsection
