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
 * [[Default route]]
 * [Redirecciona a la vista home]
 */
Route::get('/', function () {
    return redirect()->route('home');
});

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
