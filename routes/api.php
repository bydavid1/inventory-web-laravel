<?php

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
    //Api Products

    Route::get('products', 'ProductApiController@getRecords');

    Route::get('products/{id}/{columns}', 'ProductApiController@byId');

    Route::get('products/code/{code}/{columns}', 'ProductApiController@byCode');

    Route::get('products/search/{query}/{columns}', 'ProductApiController@byQuery');

    Route::get('pagination/fetch', 'ProductApiController@pagination');

    Route::get('pagination/fetch/search/{query?}', 'ProductApiController@search');

    // Api categories

    Route::get('categories', 'CategoriesController@getRecords')->middleware('api');

    Route::get('categories/{id}', 'CategoriesController@show');

    // Api suppliers

    Route::get('suppliers', 'SupplierController@getRecords');

    Route::get('suppliers/{id}', 'SupplierController@show');

    // Api manufacturers

    Route::get('manufacturers',  'ManufacturersController@getRecords');

    Route::get('manufacturers/{id}', 'ManufacturersController@show');

    //Api customers

    Route::get('customers', 'CustomerController@getRecords');

    Route::get('customer/{id}', 'CustomerController@show');

    Route::get('customers/search/{query}', 'CustomerController@byQuery');

    //Other routes

    Route::get('sales', 'SaleController@getRecords');

    Route::get('purchases', 'PurchaseController@getRecords');

    Route::get('products/kardex', 'KardexController@getProductList');



