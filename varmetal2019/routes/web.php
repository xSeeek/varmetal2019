<?php
use App\Mail\Varmetal;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contrasena', function () {
      Auth::logout();
      return redirect()->route('password.request');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

/* [** Admin Controller **] */

Route::get('/admin', 'AdminController@admin')
    ->middleware('is_supervisor')
    ->name('admin');

/* [** Trabajador Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/menuTrabajador', 'SupervisorController@menuTrabajador')
                    ->middleware('is_supervisor')
                    ->name('menuTrabajador');
        Route::get('/adminTrabajador/{tipo}', ['uses' => 'TrabajadorController@adminTrabajadores'])
                    ->middleware('is_supervisor')
                    ->name('adminTrabajador');
        Route::get('/trabajadorControl/{id}', ['uses' => 'TrabajadorController@trabajadorControl'])
                    ->middleware('is_supervisor')
                    ->name('trabajadorControl');
        Route::get('/addTrabajador', 'TrabajadorController@addTrabajador')
                    ->middleware('is_supervisor')
                    ->name('trabajador/addTrabajador');
        Route::get('/trabajador/asignarProducto/{id}', ['uses' => 'TrabajadorController@asignarTrabajo'])
                    ->middleware('is_supervisor')
                    ->name('/trabajador/asignarProducto');
        /* [** POST **] */
        Route::post('/createPassword', 'TrabajadorController@createPassword')
                    ->middleware('is_admin')
                    ->name('admin.createPassword');
        Route::post('/trabajadorControl/addTrabajador', ['uses' => 'TrabajadorController@insertTrabajador'])
                    ->middleware('is_admin')
                    ->name('trabajador/addTrabajador');
        Route::post('/trabajadorControl/deleteTrabajador', ['uses' => 'TrabajadorController@deleteTrabajador'])
                    ->middleware('is_admin')
                    ->name('trabajador/deleteTrabajador');
    /* [** VISTA GENERAL **] */
        /* [** GET **] */
        Route::get('/homepage/Trabajador', 'TrabajadorController@detallesCuentaTrabajador')
                    ->middleware('is_trabajador')
                    ->name('/homepage/Trabajador');
        Route::get('/productosTrabajador', 'TrabajadorController@productosTrabajador')
                    ->middleware('is_trabajador')
                    ->name('productosTrabajador');
        Route::get('/equipoTrabajador', 'TrabajadorController@equipoTrabajador')
                    ->middleware('is_trabajador')
                    ->name('equipoTrabajador');
        /* [** POST **] */
        Route::post('/trabajadorControl/setStartTime', ['uses' => 'TrabajadorController@setStartTime'])
                    ->middleware('is_trabajador')
                    ->name('/trabajadorControl/setStartTime');
/* [** Ayudante Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminAyudante', ['uses' => 'AyudanteController@adminAyudantes'])
                    ->middleware('is_supervisor')
                    ->name('adminAyudante');
        Route::get('/addAyudante', 'AyudanteController@addAyudante')
                    ->middleware('is_supervisor')
                    ->name('/addAyudante');
        Route::get('/ayudanteControl/{id}', ['uses' => 'AyudanteController@detalleAyudante'])
                    ->middleware('is_supervisor')
                    ->name('ayudanteControl');
        /* [** POST **] */
        Route::post('/ayudanteControl/addAyudante', 'AyudanteController@insertAyudante')
                    ->middleware('is_supervisor')
                    ->name('/ayudanteControl/addAyudante');
        Route::post('/trabajadorControl/addAyudante', ['uses' => 'AyudanteController@asignarAyudante'])
                    ->middleware('is_trabajador')
                    ->name('/trabajadorControl/addAyudante');
        Route::post('/ayudanteControl/removeEquipo', ['uses' => 'AyudanteController@removeEquipo'])
                    ->middleware('is_trabajador')
                    ->name('removeEquipo');
/* [** Producto Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/menuPiezas', 'SupervisorController@menuPiezas')
                    ->middleware('is_supervisor')
                    ->name('menuPiezas');
        Route::get('/adminProducto/{id}', ['uses' => 'ProductoController@adminProducto'])
                    ->middleware('is_supervisor')
                    ->name('adminProducto');
        Route::get('/productoControl/{id}', ['uses' => 'ProductoController@productoControl'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl');
        Route::get('/addProducto', 'ProductoController@addProducto')
                    ->middleware('is_supervisor')
                    ->name('producto/addProducto');
        Route::get('/producto/asignarTrabajo/{id}', ['uses' => 'ProductoController@asignarTrabajo'])
                    ->middleware('is_supervisor')
                    ->name('/producto/asignarTrabajo');
        Route::get('producto/asignarTrabajoSoldador/{id}', ['uses' => 'SoldaduraController@asignarTrabajo'])
                    ->middleware('is_supervisor')
                    ->name('/producto/asignarTrabajoSoldador');
        Route::get('/producto/asignarObra/{id}', ['uses' => 'ProductoController@asignarObra'])
                    ->middleware('is_supervisor')
                    ->name('/producto/asignarObra');
        /* [** POST **] */
        Route::post('/productoControl/addProducto', ['uses' => 'ProductoController@insertProducto'])
                    ->middleware('is_supervisor')
                    ->name('productoControl/addProducto');
        Route::post('/productoControl/deleteProducto', ['uses' => 'ProductoController@deleteProducto'])
                    ->middleware('is_supervisor')
                    ->name('productoControl/deleteProducto');
        Route::post('/productoControl/addWorker', ['uses' => 'ProductoController@addWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/addWorker');
        Route::post('/productoControl/addWorkerSoldador', ['uses' => 'SoldaduraController@addWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/addWorkerSoldador');
        Route::post('/productoControl/removeWorker', ['uses' => 'ProductoController@removeWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/removeWorker');
        Route::post('/productoControlSoldadura/removeWorker', ['uses' => 'SoldaduraController@removeWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControlSoldadura/removeWorker');
        Route::post('/productoControlSoldadura/reiniciarWorker', ['uses' => 'SoldaduraController@reiniciarWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControlSoldadura/reiniciarWorker');
        Route::post('/productoControl/resetProduccion', ['uses' => 'ProductoController@unmarkAsFinished'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/resetProduccion');
        Route::post('/productoControlSoldadura/añadirPiezas', ['uses' => 'SoldaduraController@añadirPiezas'])
                    ->middleware('is_supervisor')
                    ->name('/productoControlSoldadura/añadirPiezas');
        Route::post('/productoControl/finishProduccion', ['uses' => 'ProductoController@finishProducto'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/finishProduccion');
        Route::post('/productoControl/resetProducto', ['uses' => 'ProductoController@resetProducto'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/resetProducto');
        Route::post('/obraControl/addProducto', ['uses' => 'ObraController@addProducto'])
                    ->middleware('is_supervisor')
                    ->name('/obraControl/addProducto');
        Route::post('/producto/saltarProceso', ['uses' => 'ProductoController@saltarProceso'])
                    ->middleware('is_supervisor')
                    ->name('/producto/saltarProceso');
    /* [** VISTA GENERAL **] */
        /* [** GET **] */
        Route::get('/detalleProducto/{id}', ['uses' => 'ProductoController@detalleProducto'])
                    ->middleware('is_trabajador')
                    ->name('/detalleProducto');
        /* [** POST **] */
        Route::post('/producto/Finalizar', ['uses' => 'ProductoController@markAsFinished'])
                    ->middleware('is_trabajador')
                    ->name('/producto/Finalizar');
        Route::post('/producto/Anular', ['uses' => 'ProductoController@unmarkAsFinished'])
                    ->middleware('is_trabajador')
                    ->name('/producto/Anular');
        Route::post('/producto/actualizarCantidad', ['uses' => 'ProductoController@updateCantidadProducto'])
                    ->middleware('is_trabajador')
                    ->name('/producto/actualizarCantidad');
/* [** Pausa Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminPausas', 'PausaController@adminPausas')
                    ->middleware('is_admin')
                    ->name('adminPausas');
        Route::get('/adminPausas', 'PausaController@adminPausas')
                    ->middleware('is_supervisor')
                    ->name('adminPausas');
        Route::get('/adminPausasAlmacenadas/{id_producto}', ['uses' => 'PausaController@adminPausasDeProducto'])
                    ->middleware('is_admin')
                    ->name('adminPausasAlmacenadas');
        Route::get('/adminPausasAlmacenadas/{id_producto}', ['uses' => 'PausaController@adminPausasDeProducto'])
                    ->middleware('is_supervisor')
                    ->name('adminPausasAlmacenadas');
        Route::get('/adminDetallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_admin')
                    ->name('adminPausaControlGet');
        Route::get('/adminDetallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_supervisor')
                    ->name('adminPausaControlGet');
        Route::get('/trabajadorDetallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_trabajador')
                    ->name('trabajadorDetallesPausaGet');
        Route::get('/addPausa/{idProducto}', ['uses' => 'PausaController@addPausa'])
                    ->middleware('is_trabajador')
                    ->name('addPausaGet');
        Route::get('/detallesCuentaTrabajador', ['uses' => 'TrabajadorController@detallesCuentaTrabajador'])
                    ->middleware('is_trabajador')
                    ->name('detallesCuentaTrabajador');
        Route::get('/terminarProducto', ['uses' => 'TrabajadorController@terminarProducto'])
                    ->middleware('is_trabajador')
                    ->name('terminarProducto');
        /* [** POST **] */
        Route::post('/SuperPausaControl', ['uses' =>'PausaController@insertPausa'])
                    ->middleware('is_trabajador')
                    ->name('pausaControlPost');
        Route::post('/adminUpdateFechaFinPost', ['uses' =>'PausaController@trabajadorUpdateFechaFin'])
                    ->middleware('is_admin', 'is_supervisor')
                    ->name('adminUpdateFechaFinPost');
        Route::post('/adminUpdateFechaFinPost', ['uses' =>'PausaController@trabajadorUpdateFechaFin'])
                    ->middleware('is_supervisor')
                    ->name('adminUpdateFechaFinPost');
        Route::post('/trabajadorUpdateFechaFinPost', ['uses' =>'PausaController@trabajadorUpdateFechaFin'])
                    ->middleware('is_trabajador')
                    ->name('trabajadorUpdateFechaFinPost');
        Route::post('/trabajadorDeletePausa', ['uses' => 'PausaController@deletePausa'])
                    ->name('trabajadorDeletePausa');
        Route::post('/adminDeletePausa', ['uses' => 'PausaController@deletePausa'])
                    ->middleware('is_supervisor')
                    ->name('adminDeletePausa');
        Route::post('/pausaControlEditar', ['uses' => 'PausaController@editarPausa'])
                    ->name('pausaControlEditar')
                    ->middleware('is_supervisor');
/* [** Obra Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminObras', 'ObraController@adminObra')
                    ->middleware('is_supervisor')
                    ->name('adminObras');
        Route::get('/obraControl/{id}', ['uses' => 'ObraController@obraControl'])
                    ->middleware('is_supervisor')
                    ->name('/obraControl');
        Route::get('/addObra', 'ObraController@addObra')
                    ->middleware('is_supervisor')
                    ->name('obra/addObra');
            Route::get('obra/productosDisponibles/{id}', ['uses' => 'ObraController@productosDisponibles'])
                        ->middleware('is_supervisor')
                        ->name('obra/productosDisponibles');
        /* [** POST **] */
        Route::post('/obraControl/deleteProducto', ['uses' => 'ObraController@deleteProducto'])
                    ->middleware('is_supervisor')
                    ->name('/obraControl/deleteProducto');
        Route::post('/obraControl/addObra', ['uses' => 'ObraController@insertObra'])
                    ->middleware('is_admin')
                    ->name('/obraControl/addObra');
        Route::post('/obraControl/deleteObra', ['uses' => 'ObraController@deleteObra'])
                    ->middleware('is_admin')
                    ->name('/obraControl/deleteObra');

/* [** Email Controller **] */
    /* [** GENERAL **] */
        /* [** GET**] */
            Route::get('/cambiarContraseña', ['uses' => 'UserController@getProfilePassword'])
                    ->name('cambiarContraseña');//vista cambio de contraseña
            Route::get('/cambiarEmail', ['uses' => 'UserController@getProfileEmail'])
                    ->name('cambiarEmail'); //vista cambio de email
        /* [** POST **] */
            Route::post('/enviarEmail', ['uses' => 'EmailController@sendEmailPausas'])
                    ->name('enviarEmail'); //PAUSAS
            Route::post('/enviarEmailProducto', ['uses' => 'EmailController@sendEmailProducto'])
                    ->name('enviarEmailProducto'); //cada 5 productos
            Route::post('/enviarEmailTerminado', ['uses' => 'EmailController@sendEmailProductoTerminado'])
                    ->name('enviarEmailTerminado'); //producto terminado
            Route::post('/enviarEmailRegistrado',['uses' => 'EmailController@sendEmailRegistro'])
                    ->name('enviarEmailRegistrado'); //nuevo registro
            Route::post('/emailPausaEliminada',['uses' => 'EmailController@emailPausaEliminada'])
                    ->name('emailPausaEliminada'); //pausa pendiente eliminada
            Route::post('/nuevaContraseña', ['uses' => 'UserController@postProfilePassword'])
                    ->name('nuevaContraseña'); //cambio de contraseña
            Route::post('/nuevoEmail', ['uses' => 'UserController@postProfileEmail'])
                    ->name('nuevoEmail'); //cambo de email
            Route::post('/emailFinPausa', ['uses' => 'EmailController@emailFinPausa'])
                    ->name('emailFinPausa'); //Pausa eliminada

/* [** Gerencia Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/gerencia', 'GerenciaController@showObras')
                    ->name('gerencia')
                    ->middleware('is_gerente');
                    
    /* [** Editar **] */
/* [** ADMINISTRACIÓN **] */
    /* [** POST **] */
        Route::post('/trabajadorControlEditar', ['uses' => 'TrabajadorController@editar'])
                    ->name('editarTrabajador')
                    ->middleware('is_supervisor');

        Route::post('/productoControlEditar', ['uses' => 'ProductoController@editar'])
                    ->name('editarProducto')
                    ->middleware('is_supervisor');

        Route::post('/obraControlEditar', ['uses' => 'ObraController@editar'])
                    ->name('editarObra')
                    ->middleware('is_supervisor');
/* [** Import Controller] */
    /* [** GET **] */
        Route::get('/import/{id}', ['uses' => 'ImportController@getImport'])
                    ->middleware('is_supervisor')
                    ->name('import');
    /* [** POST **] */
        Route::post('/import_parse', 'ImportController@parseImport')
                    ->middleware('is_supervisor')
                    ->name('import_parse');
        Route::post('/import_process', 'ImportController@processImport')
                    ->middleware('is_supervisor')
                    ->name('import_process');
/* [**Supervisor**]*/
  /*[**loop**]*/
        Route::post('/loopInfinito', ['uses' => 'HomeController@loop'])
                    ->name('loopInfinito')
                    ->middleware('is_supervisor');

/* [**Materiales**]*/
    /*[**Trabajador**]*/
        Route::post('/materialesGastados', ['uses' => 'MaterialController@materialesGastados'])
                    ->middleware('is_trabajador')
                    ->name('materialesGastados');

        Route::post('/productoTerminado', ['uses' => 'MaterialController@productoTerminado'])
                    ->middleware('is_trabajador')
                    ->name('productoTerminado');
/* [**Pintado**] */
    /* [**Administrador**] */
        /* [** GET **] */
            Route::get('/pintadasPendientes/{id}', ['uses' => 'PinturaController@piezasPendientes'])
                        ->middleware('is_supervisor')
                        ->name('pintadasPendientes');
            Route::get('/detallesPintado/{id}', ['uses' => 'PinturaController@detallePiezaPintada'])
                        ->middleware('is_supervisor')
                        ->name('detallesPintado');
            Route::get('/pintado/pintadoControl/{id}', ['uses' => 'PinturaController@pintadoControl'])
                        ->middleware('is_supervisor')
                        ->name('pintado/pintadoControl');
            Route::get('/detalleRevision/{id}', ['uses' => 'PinturaController@detallePintadoControl'])
                        ->middleware('is_supervisor')
                        ->name('detalleRevision');
        /* [** POST **] */
            Route::post('/pintadoControl/revisarPintado', ['uses' => 'PinturaController@revisarPintado'])
                        ->middleware('is_supervisor')
                        ->name('pintadoControl/revisarPintado');
    /* [**Trabajador**] */
        /* [** GET **] */
            Route::get('/actualizarPintado', 'PinturaController@homePintor')
                        ->middleware('is_trabajador')
                        ->name('actualizarPintado');
        /* [** POST **] */
            Route::post('/pintarPieza', ['uses' => 'PinturaController@pintarPieza'])
                        ->middleware('is_trabajador')
                        ->name('pintarPieza');

            Route::get('/soldadura/soldaduraControl/{id}', ['uses' => 'SoldaduraController@soldaduraControl'])
                        ->middleware('is_supervisor')
                        ->name('soldadura/soldaduraControl');
