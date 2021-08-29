<?php

<<<<<<< HEAD
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\ManufacturersController;
=======
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\BrandController;
>>>>>>> database
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

<<<<<<< HEAD
    Route::get('dashboard/sales/last', [DashboardController::class, 'getLastSales']);

=======
>>>>>>> database
    //Api Products

    Route::get('products', [ProductApiController::class, 'getRecords']);

<<<<<<< HEAD
    Route::get('products/{id}/{columns}', [ProductApiController::class, 'byId']);

    Route::get('products/code/{code}/{columns}', [ProductApiController::class, 'byCode']);

    Route::get('products/search/{query}/{columns}', [ProductApiController::class, 'byQuery']);
=======
    Route::get('products/id/{id}/{columns}', [ProductApiController::class, 'byId']);

    Route::get('products/code/{code}/{columns}', [ProductApiController::class, 'byCode']);

    Route::get('products/query/{query}/{columns}', [ProductApiController::class, 'byQuery']);

    Route::get('products/prices/{id}', [ProductApiController::class, 'prices'])->name('api:prices');
>>>>>>> database

    Route::get('pagination/fetch', [ProductApiController::class, 'pagination']);

    Route::get('pagination/fetch/search/{query?}', [ProductApiController::class, 'search']);

<<<<<<< HEAD
    // Api categories

    Route::get('categories', [CategoriesController::class, 'getRecords'])->middleware('api');

    Route::get('categories/{id}', [CategoriesController::class, 'show']);
=======
    Route::put('products/prices/{id}/update', [ProductApiController::class, 'updatePrices'])->name('api:updatePrices');

    // Api categories

    Route::get('categories', [CategoryController::class, 'getRecords'])->middleware('api');

    Route::get('categories/{id}', [CategoryController::class, 'show']);
>>>>>>> database

    // Api suppliers

    Route::get('suppliers', [SupplierController::class, 'getRecords']);

    Route::get('suppliers/{id}', [SupplierController::class, 'show']);

    // Api manufacturers

<<<<<<< HEAD
    Route::get('manufacturers', [ManufacturersController::class, 'getRecords']);

    Route::get('manufacturers/{id}', [ManufacturersController::class, 'show']);
=======
    Route::get('brands', [BrandController::class, 'getRecords']);

    Route::get('brands/{id}', [BrandController::class, 'show']);
>>>>>>> database

    //Api customers

    Route::get('customers', [CustomerController::class, 'getRecords']);

    Route::get('customer/{id}', [CustomerController::class, 'show']);

    Route::get('customers/search/{query}', [CustomerController::class, 'byQuery']);

    //Other routes
    Route::get('kardex/products', [KardexController::class, 'getProducts']);

<<<<<<< HEAD
    Route::get('kardex/{id}/records', [KardexController::class, 'getRecords']);
=======
    Route::get('kardex/product/{id}/report', [KardexController::class, 'getProductReport'])->name('getProductReport');
>>>>>>> database

    Route::get('sales', [SaleController::class, 'getRecords']);

    Route::get('purchases', [PurchaseController::class, 'getRecords']);





