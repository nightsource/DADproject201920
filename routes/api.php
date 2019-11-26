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
Route::middleware('auth:api')->get('users/{id}', 'UserControllerAPI@show');
/*
|
|--------------------------------------------------------------------------
| POSTs
|--------------------------------------------------------------------------
*/
Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::post('register', 'UserControllerAPI@store');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

/*
|
|--------------------------------------------------------------------------
| PUTs
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@update');

/*
|
|--------------------------------------------------------------------------
| DELETEs
|--------------------------------------------------------------------------
*/
Route::delete('users/{id}', 'UserControllerAPI@destroy');