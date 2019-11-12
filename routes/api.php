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

/*
|
|--------------------------------------------------------------------------
| GETs
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->get('users', 'UserControllerAPI@index');
Route::middleware('auth:api')->get('/user', function (Request $request) { return $request->user();});

/*
|
|--------------------------------------------------------------------------
| POSTs
|--------------------------------------------------------------------------
*/
Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

