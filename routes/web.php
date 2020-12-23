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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/clientes/login', function () {
    return view('auth.login_clientes');
})->name('login_cliente');

Route::get('/clientes/login-pagina', function () {
    return view('auth.login_clientes_pagina');
})->name('login_cliente_pagina');

Route::get('/clientes/registro/', function () {
    return view('auth.register_clientes');
})->name('registro_cliente');

Route::get('/clientes/recuperar-password/', function () {
    return view('auth.passwords.email');
})->name('recuperar_cliente');


Route::get('/clientes/registro-pagina/', function () {
    return view('auth.register_clientes_pagina');
})->name('registro_cliente_pagina');



Route::post('/clientes/registro/', 'Auth\RegisterController@register')->name('registro_cliente_form');

Auth::routes();
Route::get('/home', 'HomeController@directorios');
Route::get('/deptos', 'DeptosFechaLimite@DeptosProximoVencer');

/*
 * Rutas para CRUD de Zonas
 */
Route::group([ 'middleware' => 'auth'], function() {
    Route::resource('notificaciones','NotificacionesController');
});

/*
Route::get('/exportar/{id}', 'ExportarLecturasExcelController@exportLecturasExcel')->name('home');
*/
