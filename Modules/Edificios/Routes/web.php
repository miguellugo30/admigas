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

Route::prefix('edificios')->group(function() {
    Route::get('/', 'EdificiosController@index');
});
/*
 * Rutas para CRUD de Zonas
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::resource('zonas','ZonasController');
    Route::get('zonas-breadcrumb/{id_zona}', 'ZonasController@breadcrumb' )->name('zona.breadcrumb');
});
/*
 * Rutas para CRUD de Unidades
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::resource('unidades','UnidadesController');
    Route::get('zonas-unidades/{id_zona}', 'UnidadesController@index' )->name('zona.unidades');
    Route::get('unidades-breadcrumb/{id_unidad}', 'UnidadesController@breadcrumb' )->name('unidades.breadcrumb');
});
/*
 * Rutas para CRUD de Condominios
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::resource('condominios','CondominiosController');
    Route::get('unidades-condominios/{id_unidad}', 'CondominiosController@index' )->name('unidades.condominios');
    Route::get('condominios-create/{id_unidad}', 'CondominiosController@create' )->name('unidades.condominios.create');
});
/*
 * Rutas para CRUD de Tanques
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::resource('tanques','TanquesController');
});
/*
 * Rutas para CRUD de Departamentos
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::resource('departamentos','DepartamentosController');
});
/*
 * Rutas para CRUD de Departamentos
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::get('captura-lecturas/{id_condominios}', 'CapturaLecturaController@create' )->name('captura.lectura');
    Route::post('captura-lecturas', 'CapturaLecturaController@store' )->name('captura.lectura.create');
});
/*
 * Rutas para CRUD de Recibos
 */
Route::group(['namespace' => '\Modules\Edificios\Http\Controllers', 'prefix' => 'edificios', 'middleware' => 'auth'], function() {
    Route::get('generar-recibos/{id_condominios}', 'RecibosController@create' )->name('captura.lectura');
    Route::resource('recibos','RecibosController');
});
