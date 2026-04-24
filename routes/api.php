<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', 'LoginController@index')->name('auth.login');
Route::post('/auth/login-cliente', 'LoginController@loginClient')->name('auth.login-client');
Route::post('/auth/logout', 'LoginController@logout')->name('auth.logout');

Route::post('/registro', 'ApiRegister@store')->name('auth.registros');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'edificios' => APIMobile::class,
    'cliente' => APICliente::class,
]);

Route::get('/cliente/edo-cuenta/{id}', 'ApiCliente@estado_cuenta')->name('cliente.edo_cuenta');
Route::post('/cliente/webhook', 'ApiCliente@webhook')->name('cliente.webhook');
