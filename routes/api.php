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

Route::get('/tenants/tables', 'Api\TableController@getTablesByTenantUuid');
Route::get('/tenants/table', 'Api\TableController@show');

Route::get('/tenants/category', 'Api\CategoryController@show');
Route::get('/tenants/categories', 'Api\CategoryController@getCategoriesByTenant');

Route::get('/tenants', 'Api\TenantController@index');
Route::get('/tenant/{uuid}', 'Api\TenantController@show');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
