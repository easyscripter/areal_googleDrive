<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\GoogleController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/v1/files/{parent_id}', [GoogleController::class, 'getFiles']);
Route::get('/v1/user', [LoginController::class, 'getUser']);
Route::get('/v1/sharedDrives', [GoogleController::class, 'getSharedDrives']);
