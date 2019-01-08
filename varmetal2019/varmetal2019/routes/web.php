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
        Route::get('/homepage/Trabajador', 'TrabajadorController@productosTrabajador')
                    ->middleware('is_trabajador')
                    ->name('/homepage/Trabajador');

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
        /* [** POST **] */
        Route::post('/productoControl/addProducto', ['uses' => 'ProductoController@insertProducto'])
                    ->middleware('is_admin')
                    ->name('productoControl/addProducto');
        Route::post('/productoControl/deleteProducto', ['uses' => 'ProductoController@deleteProducto'])
                    ->middleware('is_admin')
                    ->name('productoControl/deleteProducto');
    /* [** VISTA GENERAL **] */
        /* [** GET **] */
        Route::get('/detalleProducto/{id}', ['uses' => 'ProductoController@detalleProducto'])
                    ->middleware('is_trabajador')
                    ->name('/detalleProducto');
/* [** Pausa Controller **] */
    /* [** ADMINISTRACIÓN **] */
        /* [** GET **] */
        Route::get('/adminPausa', 'PausaController@adminPausas')
                    ->middleware('is_admin')
                    ->name('adminPausa');
        Route::get('/pausaControl/{id}', ['uses' => 'PausaController@pausaControl'])
                    ->middleware('is_trabajador')
                    ->name('pausaControl');
        Route::get('/pausa/addPausa', ['uses' => 'PausaController@addPausa'])
                    ->middleware('is_trabajador')
                    ->name('pausa/addPausa');
        /* [** POST **] */
        Route::post('/pausaControl/addPausa/', ['uses' => 'PausaController@insertPausa'])
                    ->middleware('is_trabajador')
                    ->name('pausa/addPausa');
