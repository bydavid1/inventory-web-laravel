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

// Products routes

Route::get('products', 'ProductController@getRecords');

Route::get('products/order/{id}/{options}', 'ProductController@byId'); //options parameter can be: all, compact...

Route::get('products/order/code/{code}', 'ProductController@byCode');

Route::get('products/order/search/{query}', 'ProductController@byQuery');

// Products categories

Route::get('categories', 'CategoriesController@getRecords');

Route::get('categories/{id}', 'CategoriesController@show');

// Products suppliers

Route::get('suppliers', 'SupplierController@getRecords');

Route::get('suppliers/{id}', 'SupplierController@show');

// Products manufacturers

Route::get('manufacturers',  'ManufacturersController@getRecords');

Route::get('manufacturers/{id}', 'ManufacturersController@show');

//Customers routes

Route::get('customers', 'CostumerController@getRecords');

Route::get('customer/{id}', 'CostumerController@show');

Route::get('costumers/search/{query}', 'CostumerController@byQuery');

//Other routes

Route::get('sales', 'SaleController@getRecords');

Route::get('purchases', 'PurchaseController@getRecords');

Route::get('products/kardex', 'KardexController@getProductList');