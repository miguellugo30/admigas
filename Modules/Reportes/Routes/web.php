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

Route::prefix('reportes')->group(function() {
    Route::get('/', 'ReportesController@index');
});
/*
 * Rutas para CRUD de Saldos
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::resource('saldos','SaldosController');
});
/*
 * Rutas para CRUD de Antiguedad Saldos
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::resource('antiguedad','AntiguedadController');
});
/*
 * Rutas para CRUD de Cargos Adicionales
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::resource('cargos-adicionales','CargosController');
});
/*
 * Rutas para CRUD de Cargos Adicionales
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::get('litros/export/{fecha_inicial}/{fecja_final}', 'ListrosController@export' );
    Route::resource('litros','ListrosController');
});
/*
 * Rutas para CRUD de Cargos Adicionales
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::resource('estado-cuenta','EstadoCuentaController');
});
/*
 * Rutas para CRUD de Reporte Pagos Manual
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::resource('reporte-pagos-manual','PagosManualController');
});
/*
 * Rutas para CRUD de Reporte Recibos Generados Mensualmente
 */
Route::group(['namespace' => '\Modules\Reportes\Http\Controllers', 'prefix' => 'reportes', 'middleware' => 'auth'], function() {
    Route::get('litros/export/{fecha_inicial}/{fecja_final}', 'ReporteRecibosGeneradosMensualController@export' );
    Route::resource('recibos-generados','ReporteRecibosGeneradosMensualController');
});
