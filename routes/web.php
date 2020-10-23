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
    return redirect('usuarios');
})->middleware('verifyLoggedIn');

Route::resource('usuarios', 'UsuariosController')->only(['index', 'create'])->middleware('verifyLoggedIn');

Route::resource('usuarios', 'UsuariosController')->except(['index', 'create']);

Route::Post('usuarios/login', 'UsuariosController@login');

Route::Post('usuarios/logout', 'UsuariosController@logout');

Route::resource('contatos', 'ContatosController', [
    'names' => [
        'show' => 'contatos.show',
        'update' => 'contatos.update',
        'destroy' => 'contatos.destroy'
    ]
])->middleware('verifyLogin');
