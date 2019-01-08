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


Route::post('/registrarAsistencia', 'AsistenciaController@registrarAsistencia')
  ->name('registrarAsistencia');
