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



Route::group(['middleware' => 'auth'], function () {
    Route::get("enterprise/getProducts/{enterpriseID}", "EnterpriseController@getProducts");
    Route::get("enterprise/getStorages/{enterpriseID}", "EnterpriseController@getStorages");
    Route::get("enterprise/isRegNumberFree/{registration_number}", "EnterpriseController@isRegNumberFree");
    Route::get("enterprise/getNotIncludedProducts/{enterpriseID}", "EnterpriseController@getNotIncludedProducts");
    Route::get("enterprise/getDepartments/{enterpriseID}", "EnterpriseController@getDepartments");
    Route::get("enterprise/getPositions/{enterpriseID}", "EnterpriseController@getPositions");
    Route::get("enterprise/getEnterprisesWithResources", "EnterpriseController@getEnterprisesWithResources");
    Route::post("enterprise/attachProducts", "EnterpriseController@attachProducts");
    Route::post("enterprise/removeProductFromEnterprise", "EnterpriseController@removeProductFromEnterprise");
    Route::post("enterprise/updateProductSalePrice", "EnterpriseController@updateProductSalePrice");
    Route::put("enterprise/addProductAmount/{enterpriseID}", "EnterpriseController@addProductAmount");


    Route::get("storage/getProducts/{storageID}", "StorageController@getProducts");
    Route::get("storage/getNotIncludedProduct/{storageID}", "StorageController@getNotIncludedProduct");
    Route::post("storage/addProductToStorage", "StorageController@addProductToStorage");
    Route::post("storage/removeProductFromStorage", "StorageController@removeProductFromStorage");
    Route::put("storage/addPalletes/{storageID}", "StorageController@addPalletes");


    Route::resource('shipping', 'ShippingController');
    Route::get('shipping/completeShipping/{shipping_id}', "ShippingController@completeShipping");
    Route::get('shipping/cancelShipping/{shipping_id}', "ShippingController@cancelShipping");
    Route::get('shipping/getShippingUnperfomableProducts/{shipping_id}', "ShippingController@getShippingUnperfomableProducts");


    Route::get("sale/getUnperfomableProducts/{sale_id}", "SaleController@getUnperfomableProducts");
    Route::get("sale/completeSale/{sale_id}", "SaleController@completeSale");
    Route::get("sale/cancelSale/{sale_id}", "SaleController@cancelSale");


    Route::get("department/getEnterprises/{departmentID}", "DepartmentController@getEnterprises")->middleware("role:admin,director,hr_manager");


    Route::get("position/getEnterprises/{positionID}", "PositionController@getEnterprises")->middleware("role:admin,director,hr_manager");

    Route::resource('resource', 'ResourceController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('resource', 'ResourceController')->only(["index", "show"]);

    Route::resource('enterprise', 'EnterpriseController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('enterprise', 'EnterpriseController')->only(["index", "show"]);

    Route::resource('storage', 'StorageController');

    Route::resource('product', 'ProductController');

    Route::resource('department', 'DepartmentController');

    Route::resource('status', 'StatusController');

    Route::resource('position', 'PositionController');

    Route::resource('sale', 'SaleController');

    Route::resource('user', 'UserController');
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});