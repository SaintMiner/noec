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

Route::get("enterprise/getProducts/{enterpriseID}", "EnterpriseController@getProducts");

Route::resource('resource', 'ResourceController');

Route::resource('enterprise', 'EnterpriseController');

