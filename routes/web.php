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

Route::get('/clientes/registro/', function () {
    return view('auth.register_clientes');
})->name('registro_cliente');

Route::post('/clientes/registro/', 'Auth\RegisterController@register')->name('registro_cliente_form');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

