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

Route::prefix('configuracion')->group(function() {
    Route::get('/', 'ConfiguracionController@index');
});
/*
 * Rutas para CRUD de Precio Gas
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('usuarios','UsuariosController');
});
/*
 * Rutas para CRUD de Precio Gas
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('precio-gas','PrecioGasController');
});
