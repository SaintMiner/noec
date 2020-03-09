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
Route::get("enterprise/getStorages/{enterpriseID}", "EnterpriseController@getStorages");
Route::get("enterprise/isRegNumberFree/{registration_number}", "EnterpriseController@isRegNumberFree");

Route::get("storage/getProducts/{storageID}", "StorageController@getProducts");


Route::resource('resource', 'ResourceController');

Route::resource('enterprise', 'EnterpriseController');

Route::resource('storage', 'StorageController');

Route::resource('product', 'ProductController');