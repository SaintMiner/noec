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
    Route::get("enterprise/getProducts/{enterpriseID}", "EnterpriseController@getProducts")->middleware("role:admin,director,wr_manager");
    Route::get("enterprise/getStorages/{enterpriseID}", "EnterpriseController@getStorages")->middleware("role:admin,director,wr_manager");
    Route::get("enterprise/isRegNumberFree/{registration_number}", "EnterpriseController@isRegNumberFree");
    Route::get("enterprise/getNotIncludedProducts/{enterpriseID}", "EnterpriseController@getNotIncludedProducts")->middleware("role:admin,director,wr_manager");
    Route::get("enterprise/getDepartments/{enterpriseID}", "EnterpriseController@getDepartments");
    Route::get("enterprise/getPositions/{enterpriseID}", "EnterpriseController@getPositions");
    Route::get("enterprise/getEnterprisesWithResources", "EnterpriseController@getEnterprisesWithResources");
    Route::post("enterprise/attachProducts", "EnterpriseController@attachProducts")->middleware("role:admin,director,wr_manager");
    Route::post("enterprise/removeProductFromEnterprise", "EnterpriseController@removeProductFromEnterprise")->middleware("role:admin,director,wr_manager");
    Route::post("enterprise/updateProductSalePrice", "EnterpriseController@updateProductSalePrice")->middleware("role:admin,director,wr_manager");
    Route::put("enterprise/addProductAmount/{enterpriseID}", "EnterpriseController@addProductAmount")->middleware("role:admin,director,wr_manager");


    Route::get("storage/getProducts/{storageID}", "StorageController@getProducts")->middleware("role:admin,director,wr_manager");
    Route::get("storage/getNotIncludedProduct/{storageID}", "StorageController@getNotIncludedProduct")->middleware("role:admin,director,wr_manager");
    Route::post("storage/addProductToStorage", "StorageController@addProductToStorage")->middleware("role:admin,director,wr_manager");
    Route::post("storage/removeProductFromStorage", "StorageController@removeProductFromStorage")->middleware("role:admin,director,wr_manager");
    Route::put("storage/addPalletes/{storageID}", "StorageController@addPalletes")->middleware("role:admin,director,wr_manager");


    Route::get('shipping/completeShipping/{shipping_id}', "ShippingController@completeShipping")->middleware("role:admin,director,or_manager");
    Route::get('shipping/cancelShipping/{shipping_id}', "ShippingController@cancelShipping")->middleware("role:admin,director,or_manager");
    Route::get('shipping/getShippingUnperfomableProducts/{shipping_id}', "ShippingController@getShippingUnperfomableProducts")->middleware("role:admin,director,or_manager");


    Route::get("sale/getUnperfomableProducts/{sale_id}", "SaleController@getUnperfomableProducts")->middleware("role:admin,director,or_manager");
    Route::get("sale/completeSale/{sale_id}", "SaleController@completeSale")->middleware("role:admin,director,or_manager");
    Route::get("sale/cancelSale/{sale_id}", "SaleController@cancelSale")->middleware("role:admin,director,or_manager");


    Route::get("department/getEnterprises/{departmentID}", "DepartmentController@getEnterprises")->middleware("role:admin,director,hr_manager");


    Route::get("position/getEnterprises/{positionID}", "PositionController@getEnterprises")->middleware("role:admin,director,hr_manager");

    Route::resource('resource', 'ResourceController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('resource', 'ResourceController')->only(["index", "show"]);

    Route::resource('enterprise', 'EnterpriseController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('enterprise', 'EnterpriseController')->only(["index", "show"]);

    Route::resource('storage', 'StorageController')->middleware("role:admin,director,wr_manager")->only(["store", "update", "destroy"]);
    Route::resource('storage', 'StorageController')->only(["index", "show"]);

    Route::resource('product', 'ProductController')->middleware("role:admin,director,wr_manager")->only(["store", "update", "destroy"]);
    Route::resource('product', 'ProductController')->only(["index", "show"]);

    Route::resource('department', 'DepartmentController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('department', 'DepartmentController')->only(["index", "show"]);

    Route::resource('status', 'StatusController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('status', 'StatusController')->only(["index", "show"]);

    Route::resource('position', 'PositionController')->middleware("role:admin,director,hr_manager")->only(["store", "update", "destroy"]);
    Route::resource('position', 'PositionController')->only(["index", "show"]);

    Route::resource('sale', 'SaleController')->middleware("role:admin,director,accountent,or_manager");
    Route::resource('shipping', 'ShippingController')->middleware("role:admin,director,accountent,or_manager");

    Route::resource('user', 'UserController')->middleware("role:admin,director")->only(["store", "update", "destroy"]);
    Route::resource('user', 'UserController')->only(["index", "show"]);

    Route::resource('role', 'RoleController');
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