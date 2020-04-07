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
Route::get("enterprise/getNotIncludedProducts/{enterpriseID}", "EnterpriseController@getNotIncludedProducts");
Route::post("enterprise/attachProducts", "EnterpriseController@attachProducts");
Route::post("enterprise/removeProductFromEnterprise", "EnterpriseController@removeProductFromEnterprise");
Route::put("enterprise/addProductAmount/{enterpriseID}", "EnterpriseController@addProductAmount");


Route::get("storage/getProducts/{storageID}", "StorageController@getProducts");
Route::get("storage/getNotIncludedProduct/{storageID}", "StorageController@getNotIncludedProduct");
Route::post("storage/addProductToStorage", "StorageController@addProductToStorage");
Route::post("storage/removeProductFromStorage", "StorageController@removeProductFromStorage");
Route::put("storage/addPalletes/{storageID}", "StorageController@addPalletes");


Route::resource('shipping', 'ShippingController');
Route::get('shipping/acceptShipping/{shipping_id}', "ShippingController@acceptShipping");
Route::get('shipping/cancelShipping/{shipping_id}', "ShippingController@cancelShipping");


Route::resource('resource', 'ResourceController');

Route::resource('enterprise', 'EnterpriseController');

Route::resource('storage', 'StorageController');

Route::resource('product', 'ProductController');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});