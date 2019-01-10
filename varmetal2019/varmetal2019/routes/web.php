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

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

/* [** Admin Controller **] */

Route::get('/admin', 'AdminController@admin')
    ->middleware('is_admin')
    ->name('admin');

/* [** Trabajador Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminTrabajador', 'TrabajadorController@adminTrabajadores')
                    ->middleware('is_admin')
                    ->name('adminTrabajador');
        Route::get('/trabajadorControl/{id}', ['uses' => 'TrabajadorController@trabajadorControl'])
                    ->middleware('is_admin')
                    ->name('trabajadorControl');
        Route::get('/addTrabajador', 'TrabajadorController@addTrabajador')
                    ->middleware('is_admin')
                    ->name('trabajador/addTrabajador');
        Route::get('/trabajador/asignarProducto/{id}', ['uses' => 'TrabajadorController@asignarTrabajo'])
                    ->middleware('is_admin')
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

/* [** Producto Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminProducto', 'ProductoController@adminProducto')
                    ->middleware('is_admin')
                    ->name('adminProducto');
        Route::get('/productoControl/{id}', ['uses' => 'ProductoController@productoControl'])
                    ->middleware('is_admin')
                    ->name('/productoControl');
        Route::get('/addProducto', 'ProductoController@addProducto')
                    ->middleware('is_admin')
                    ->name('producto/addProducto');
        Route::get('/producto/asignarTrabajo/{id}', ['uses' => 'ProductoController@asignarTrabajo'])
                    ->middleware('is_admin')
                    ->name('/producto/asignarTrabajo');
        /* [** POST **] */
        Route::post('/productoControl/addProducto', ['uses' => 'ProductoController@insertProducto'])
                    ->middleware('is_admin')
                    ->name('productoControl/addProducto');
        Route::post('/productoControl/deleteProducto', ['uses' => 'ProductoController@deleteProducto'])
                    ->middleware('is_admin')
                    ->name('productoControl/deleteProducto');
        Route::post('/productoControl/addWorker', ['uses' => 'ProductoController@addWorker'])
                    ->middleware('is_admin')
                    ->name('/productoControl/addWorker');
        Route::post('/productoControl/removeWorker', ['uses' => 'ProductoController@removeWorker'])
                    ->middleware('is_admin')
                    ->name('/productoControl/removeWorker');
    /* [** VISTA GENERAL **] */
        /* [** GET **] */
        Route::get('/detalleProducto/{id}', ['uses' => 'ProductoController@detalleProducto'])
                    ->middleware('is_trabajador')
                    ->name('/detalleProducto');
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
