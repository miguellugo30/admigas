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
 * Rutas para CRUD de Usuarios
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
/*
 * Rutas para CRUD de Menus
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('menus','MenusController');
});
/*
 * Rutas para CRUD de Mensajes
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('mensajes','MensajesController');
});
/*
 * Rutas para CRUD de Empresas
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('empresas','EmpresasController');
});
/*
 * Rutas para CRUD de Servicios
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('servicios','ServiciosController');
});
/*
 * Rutas para CRUD de Lecturistas
 */
Route::group(['namespace' => '\Modules\Configuracion\Http\Controllers', 'prefix' => 'configuracion', 'middleware' => 'auth'], function() {
    Route::resource('lecturistas','LecturistasController');
});
