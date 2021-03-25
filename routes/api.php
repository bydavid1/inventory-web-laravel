<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
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

    //Api Dashboard
    Route::get('dashboard/tiles', [DashboardController::class, 'getTilesData']);

    Route::get('dashboard/chart', [DashboardController::class, 'getSalesChart']);

    //Api Products

    Route::get('products', [ProductApiController::class, 'getRecords']);

    Route::get('products/{id}/{columns}', [ProductApiController::class, 'getRecbyIdords']);

    Route::get('products/code/{code}/{columns}', [ProductApiController::class, 'byCode']);

    Route::get('products/search/{query}/{columns}', [ProductApiController::class, 'byQuery']);

    Route::get('pagination/fetch', [ProductApiController::class, 'pagination']);

    Route::get('pagination/fetch/search/{query?}', [ProductApiController::class, 'search']);

    // Api categories

    Route::get('categories', [CategoriesController::class, 'getRecords'])->middleware('api');

    Route::get('categories/{id}', [CategoriesController::class, 'show']);

    // Api suppliers

    Route::get('suppliers', [SupplierController::class, 'getRecords']);

    Route::get('suppliers/{id}', [SupplierController::class, 'show']);

    // Api manufacturers

    Route::get('manufacturers', [ManufacturersController::class, 'getRecords']);

    Route::get('manufacturers/{id}', [ManufacturersController::class, 'show']);

    //Api customers

    Route::get('customers', [CustomerController::class, 'getRecords']);

    Route::get('customer/{id}', [CustomerController::class, 'show']);

    Route::get('customers/search/{query}', [CustomerController::class, 'byQuery']);

    //Other routes
    Route::get('kardex/products', [KardexController::class, 'getProducts']);

    Route::get('kardex/{id}/records', [KardexController::class, 'getRecords']);

    Route::get('sales', [SaleController::class, 'getRecords']);

    Route::get('purchases', [PurchaseController::class, 'getRecords']);





