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
