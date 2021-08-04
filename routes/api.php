<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\BrandController;
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

    Route::get('products/id/{id}/{columns}', [ProductApiController::class, 'byId']);

    Route::get('products/code/{code}/{columns}', [ProductApiController::class, 'byCode']);

    Route::get('products/query/{query}/{columns}', [ProductApiController::class, 'byQuery']);

    Route::get('products/prices/{id}', [ProductApiController::class, 'prices'])->name('api:prices');

    Route::get('pagination/fetch', [ProductApiController::class, 'pagination']);

    Route::get('pagination/fetch/search/{query?}', [ProductApiController::class, 'search']);

    Route::put('products/prices/{id}/update', [ProductApiController::class, 'updatePrices'])->name('api:updatePrices');

    // Api categories

    Route::get('categories', [CategoryController::class, 'getRecords'])->middleware('api');

    Route::get('categories/{id}', [CategoryController::class, 'show']);

    // Api suppliers

    Route::get('suppliers', [SupplierController::class, 'getRecords']);

    Route::get('suppliers/{id}', [SupplierController::class, 'show']);

    // Api manufacturers

    Route::get('brands', [BrandController::class, 'getRecords']);

    Route::get('brands/{id}', [BrandController::class, 'show']);

    //Api customers

    Route::get('customers', [CustomerController::class, 'getRecords']);

    Route::get('customer/{id}', [CustomerController::class, 'show']);

    Route::get('customers/search/{query}', [CustomerController::class, 'byQuery']);

    //Other routes
    Route::get('kardex/products', [KardexController::class, 'getProducts']);

    Route::get('kardex/{id}/records', [KardexController::class, 'getRecords']);

    Route::get('sales', [SaleController::class, 'getRecords']);

    Route::get('purchases', [PurchaseController::class, 'getRecords']);





