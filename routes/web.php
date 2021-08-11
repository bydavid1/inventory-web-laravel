<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register', function(){
    return view('pages.auth.register');
})->name('register');

//Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products')->middleware('auth');
    Route::get('/create', [ProductController::class, 'create'])->name('addProduct')->middleware('auth');
    Route::post('/store', [ProductController::class, 'store'])->name('storeProduct')->middleware('auth');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('editProduct');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('updateProduct')->middleware('auth');
    Route::get('/show/{id}', [ProductController::class, 'show'])->name('showProduct')->middleware('auth');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('deleteProduct')->middleware('auth'); //update
    //Route::delete('product/delete', 'ProductController@destroy')->name('deleteProduct')->middleware('auth');
});

//Categories Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories')->middleware('auth'); //index
    Route::post('/store', [CategoryController::class, 'store'])->name('storeCategory')->middleware('auth'); //store
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('updateCategory')->middleware('auth'); //update
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('deleteCategory')->middleware('auth'); //update
});

//Suppliers Routes
Route::prefix('suppliers')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('suppliers')->middleware('auth'); //index
    Route::post('/store', [SupplierController::class, 'store'])->name('storeSupplier')->middleware('auth'); //store
    Route::put('/update/{id}', [SupplierController::class, 'update'])->name('updateSupplier')->middleware('auth'); //update
    Route::put('/delete/{id}', [SupplierController::class, 'delete'])->name('deleteSupplier')->middleware('auth'); //delete (trash)
});

//manufacturers Routes
Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brands')->middleware('auth'); //index
    Route::post('/store', [BrandController::class, 'store'])->name('storeBrand')->middleware('auth'); //store
    Route::put('/update/{id}', [BrandController::class, 'update'])->name('updateBrand')->middleware('auth'); //update
    Route::delete('/delete/{id}', [BrandController::class, 'delete'])->name('deleteBrand')->middleware('auth'); //update
});

//Customer routes´
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers')->middleware('auth'); //index view
    Route::post('/store', [CustomerController::class, 'store'])->name('storeCustomer')->middleware('auth'); //store
    Route::put('/update/{id}', [CustomerController::class, 'update'])->name('updateCustomer')->middleware('auth'); //update
    Route::put('/delete/{id}', [CustomerController::class, 'delete'])->name('deleteCustomer')->middleware('auth'); //delete (trash)
    //Route::delete('customer/remove/{id}', 'CostumerController@destroy')->name('deleteCostumer')->middleware('auth');
});

//Sales Routes
Route::prefix('sales')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('sales')->middleware('auth');
    Route::get('/create', [SaleController::class, 'create'])->name('addSale')->middleware('auth');
    Route::post('/create/store', [SaleController::class, 'store'])->name('storeSale')->middleware('auth');
    Route::get('/invoice/show/{id}', [SaleController::class, 'showInvoice'])->name('showInvoice')->middleware('auth');
});

//Purchases
Route::prefix('purchases')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'])->name('purchases')->middleware('auth');
    Route::get('/create', [PurchaseController::class, 'create'])->name('addPurchase')->middleware('auth');
    Route::post('/create/makePurchase', [PurchaseController::class, 'store'])->name('storePurchase')->middleware('auth');
    Route::get('/create/getlist', [PurchaseController::class, 'GetList'])->name('getList')->middleware('auth');
});

//Kardex
Route::prefix('kardex')->group(function () {
    Route::get('/', [KardexController::class, 'index'])->name('kardex')->middleware('auth');
    Route::get('/records/{id}', [KardexController::class, 'records'])->name('records')->middleware('auth');
});

//Credits
Route::prefix('credits')->group(function () {
    Route::get('/create', [CreditController::class, 'create'])->name('addCredit');
    Route::post('/create/store', [CreditController::class, 'store'])->name('storeCredit');
});
