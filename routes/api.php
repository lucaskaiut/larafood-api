<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function(){

    Route::group(['namespace' => 'Auth', 'middleware' => 'auth:sanctum'], function(){
        Route::post('/logout', 'AuthClientController@logout');
        Route::post('/me', 'AuthClientController@me');
    });

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::post('/order/evaluation/create', 'OrderEvaluationController@store');

        Route::post('/auth/order/create', 'OrderController@store');
        Route::get('/auth/orders', 'OrderController@getClientAuthenticatedOrders');
    });

    Route::get('/order', 'OrderController@show');
    Route::post('/order/create', 'OrderController@store');

    Route::post('/sanctum/token', 'Auth\AuthClientController@auth');
    Route::post('/client/create', 'Auth\RegisterController@store');

    Route::any('/products', 'ProductController@getAllProducts');
    Route::any('/tenants/products', 'ProductController@getProductsByTenantUuid');
    Route::get('/product', 'ProductController@show');

    Route::get('/tenants/tables', 'TableController@getTablesByTenantUuid');
    Route::get('/table', 'TableController@show');

    Route::get('/categories', 'CategoryController@getCategoriesGrouped');
    Route::get('/tenants/categories', 'CategoryController@getCategoriesByTenant');
    Route::get('/category', 'CategoryController@show');

    Route::get('/tenants', 'TenantController@index');
    Route::get('/tenant', 'TenantController@show');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
