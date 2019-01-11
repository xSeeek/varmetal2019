<?php

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

/**
 * [[Rutas del controlador IndexController]]
 */
  Route::get('/', 'IndexController@index')->name('index');

/**
 * [[Rutas del sitema de registro y login]]
 */
 Auth::routes();

//------------------------------------------------//

/**
 * [[Rutas del controlador HomeController]]
 * [Ruta home: página principal]
 */
  Route::get('/home', 'HomeController@index')->name('home');

/**
 * [[Rutas Controlador AsistenciaController]]
 */
 //Ruta para registrar una asistencia
Route::post('/registrarAsistencia', ['uses'=>'AsistenciaController@registrarAsistencia'])
  ->name('registrarAsistencia');

Route::get('/menuAdministrador', 'AsistenciaController@menuAdministrador')
  ->name('administrador.menuAdministrador')
  ->middleware('is_admin');


/**
 * [[Controller Obra]]
 */
Route::get('/menuAdministrador/detallesObra/{id}', ['uses'=>'ObraController@detallesObra'])
  ->name('administrador.detallesObra')
  ->middleware('is_admin');


Route::get('/menuAdministrador/agregarObra', 'ObraController@agregarObra')
  ->name('administrador.agregarObra')
  ->middleware('is_admin');

Route::post('menuAdministrador/agregarObra/insert', 'ObraController@insertObra')
  ->name('administrador.insertObra')
  ->middleware('is_admin');

Route::post('menuAdministrador/detallesObra/{idObra}/registrarTrabajador', ['uses'=>'ObraController@registrarTrabajadores'])
  ->name('administrador.registrarTrabajadorObra')
  ->middleware('is_admin');
