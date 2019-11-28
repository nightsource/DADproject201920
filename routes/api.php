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
Route::middleware(['auth:api', 'admin:api'])->get('users', 'UserControllerAPI@index'); //admin only
Route::middleware('auth:api')->get('user', 'UserControllerAPI@get');
Route::middleware('auth:api')->get('users/{id}', 'UserControllerAPI@show'); //only the user can access is user

Route::middleware(['auth:api', 'admin:api'])->get('wallets', 'WalletControllerAPI@index'); //admin only
Route::middleware('auth:api')->get('user/wallet', 'WalletControllerAPI@get'); //only the user can access is wallet


Route::middleware(['auth:api', 'admin:api'])->get('movements', 'MovementControllerAPI@index'); //admin only
Route::middleware(['auth:api', 'admin:api'])->get('movement/{id}', 'MovementControllerAPI@show'); //admin only
Route::middleware('auth:api')->get('user/movements', 'MovementControllerAPI@get'); //only the user can access is movements
Route::middleware('auth:api')->get('user/movements/incomes', 'MovementControllerAPI@getIncome'); //only the user can access is movements
Route::middleware('auth:api')->get('user/movements/expenses', 'MovementControllerAPI@getExpense'); //only the user can access is movements
Route::middleware('auth:api')->get('user/movements/{id}', 'MovementControllerAPI@show'); //only the user can access his detailed movement
/*
|
|--------------------------------------------------------------------------
| POSTs
|--------------------------------------------------------------------------
*/
Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::post('register', 'UserControllerAPI@store');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

Route::middleware(['auth:api', 'operator:api'])->post('registerincomebyoperator', 'MovementControllerAPI@registerIncomeByOperator');

/*
|
|--------------------------------------------------------------------------
| PUTs
|--------------------------------------------------------------------------
*/
Route::put('users/{id}', 'UserControllerAPI@update');

/*
|
|--------------------------------------------------------------------------
| DELETEs
|--------------------------------------------------------------------------
*/
Route::delete('users/{id}', 'UserControllerAPI@destroy');