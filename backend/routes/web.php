<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login/google', 'App\Http\Controllers\Auth\LoginController@login');

Route::get('/login/google/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderGoogleCalllback');
Route::get('/user/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', 'App\Http\Controllers\SpaController@index')->where('any', '.*');
Route::get('/{any}', 'App\Http\Controllers\SpaController@index')->where('any', '.*');
Route::get('/{any}/{any1}', 'App\Http\Controllers\SpaController@index')->where('any', '.*');

