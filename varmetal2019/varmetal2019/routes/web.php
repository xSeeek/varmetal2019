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
        /* [** POST **] */
        Route::post('/trabajadorControl/setStartTime', ['uses' => 'TrabajadorController@setStartTime'])
                    ->middleware('is_trabajador')
                    ->name('/trabajadorControl/setStartTime');

/* [** Producto Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminProducto', 'ProductoController@adminProducto')
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
        Route::post('/productoControl/removeWorker', ['uses' => 'ProductoController@removeWorker'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/removeWorker');
        Route::post('/productoControl/resetProduccion', ['uses' => 'ProductoController@unmarkAsFinished'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/resetProduccion');
        Route::post('/productoControl/finishProduccion', ['uses' => 'ProductoController@finishProducto'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/finishProduccion');
        Route::post('/productoControl/resetProducto', ['uses' => 'ProductoController@resetProducto'])
                    ->middleware('is_supervisor')
                    ->name('/productoControl/resetProducto');
        Route::post('/obraControl/addProducto', ['uses' => 'ObraController@addProducto'])
                    ->middleware('is_supervisor')
                    ->name('/obraControl/addProducto');
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
        Route::get('/adminPausasAlmacenadas/{id_producto}', ['uses' => 'PausaController@adminPausasDeProducto'])
                    ->middleware('is_admin')
                    ->name('adminPausasAlmacenadas');
        /*Route::get('/detallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_trabajador')
                    ->name('pausaControlGet');*/
        Route::get('/adminDetallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_admin')
                    ->name('adminPausaControlGet');
        Route::get('/trabajadorDetallesPausaGet/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_trabajador')
                    ->name('trabajadorDetallesPausaGet');
        Route::get('/addPausa/{idProducto}', ['uses' => 'PausaController@addPausa'])
                    ->middleware('is_trabajador')
                    ->name('addPausaGet');
        /* [** POST **] */
        Route::post('/SuperPausaControl', ['uses' =>'PausaController@insertPausa'])
                    ->middleware('is_trabajador')
                    ->name('pausaControlPost');
        Route::post('/adminUpdateFechaFinPost', ['uses' =>'PausaController@updateFechaFin'])
                    ->middleware('is_admin')
                    ->name('adminUpdateFechaFinPost');
        Route::post('/trabajadorUpdateFechaFinPost', ['uses' =>'PausaController@trabajadorUpdateFechaFin'])
                    ->middleware('is_trabajador')
                    ->name('trabajadorUpdateFechaFinPost');
        /*Route::get('/SuperPausaControl', ['uses' =>'PausaController@insertPausa'])
                    ->middleware('is_trabajador')
                  ->name('pausaControlGet');*/
        Route::get('/detallesCuentaTrabajador', ['uses' => 'TrabajadorController@detallesCuentaTrabajador'])
                    ->middleware('is_trabajador')
                    ->name('detallesCuentaTrabajador');
        Route::post('/trabajadorDeletePausa', ['uses' => 'PausaController@deletePausa'])
                    ->middleware('is_trabajador')
                    ->name('trabajadorDeletePausa');
        Route::post('/adminDeletePausa', ['uses' => 'PausaController@deletePausa'])
                    ->middleware('is_admin')
                    ->name('adminDeletePausa');

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

/* [** Email Controller **] */
    /* [** GENERAL **] */
      /* [** POST **] */
        Route::post('/enviarEmail', ['uses' => 'EmailController@sendEmailPausas'])
                    ->name('enviarEmail'); //PAUSAS
        Route::post('/enviarEmailProducto', ['uses' => 'EmailController@sendEmailProducto'])
                    ->name('enviarEmailProducto');
        Route::post('/enviarEmailTerminado', ['uses' => 'EmailController@sendEmailProductoTerminado'])
                    ->name('enviarEmailTerminado');
