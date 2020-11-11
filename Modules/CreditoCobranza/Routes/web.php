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
 * Rutas para CRUD de Usuarios
 */
Route::group(['namespace' => '\Modules\CreditoCobranza\Http\Controllers', 'prefix' => 'credito-cobranza', 'middleware' => 'auth'], function() {
    Route::resource('pagos-portal','PagosPortalController');
});
