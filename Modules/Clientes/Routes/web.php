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

Route::group(['prefix' => 'clientes', 'middleware' => 'auth'], function() {
    Route::get('/', 'ClientesController@index');
    Route::get('/{id}', 'ClientesController@show');
    Route::post('/mi_cuenta', 'ClientesController@mi_cuenta');
    Route::post('/estado_cuenta', 'ClientesController@estado_cuenta');
    Route::post('/medios_contacto', 'ClientesController@medios_contacto');
    Route::get('/showRecibo/{id}/{option}', 'ClientesController@showRecibo')->where(array('id' => '[0-9]+'));
    Route::post('/update_departamento/{id}', 'ClientesController@update');
});