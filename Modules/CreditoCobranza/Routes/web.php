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

Route::prefix('credito-cobranza')->group(function() {
    Route::get('/', 'CreditoCobranzaController@index');
});

/*
 * Rutas para CRUD de Portal Pagos
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('pagos-portal','PagosPortalController');
});
/*
 * Rutas para CRUD conciliacion
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('conciliacion','ConciliacionController');
});
/*
 * Rutas para CRUD de pagos conciliados
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('pagos-conciliados','PagosConciliadosController');
});
/*
 * Rutas para CRUD de pagos no conciliados
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('pagos-no-conciliados','PagosNoConciliadosController');
});
/*
 * Rutas para CRUD de pagos manual
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('pagos-manual','PagosManualController');
});
/*
 * Rutas para CRUD de conciliacion manual
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::get('buscar-edificio/{id_unidad}', 'ConciliacionManualController@search_edificio' )->name('search.unidad');
    Route::get('buscar-depto/{id_edificio}', 'ConciliacionManualController@search_departamento' )->name('search.depto');
    Route::resource('conciliacion-manual','ConciliacionManualController');
});
