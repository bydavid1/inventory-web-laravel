<?php

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
Route::get('/products', 'ProductController@index')->name('products')->middleware('auth');
Route::get('product/create', 'ProductController@create')->name('addProduct')->middleware('auth');
Route::post('product/store', 'ProductController@store')->name('storeProduct')->middleware('auth');
Route::get('product/edit/{id}', 'ProductController@edit')->name('editProduct');
Route::put('product/update/{id}', 'ProductController@update')->name('updateProduct')->middleware('auth');
Route::get('product/show/{id}', 'ProductController@show')->name('showProduct')->middleware('auth');
Route::put('product/delete', 'ProductController@delete')->name('deleteProduct')->middleware('auth'); //update
//Route::delete('product/delete', 'ProductController@destroy')->name('deleteProduct')->middleware('auth');

//Categories Routes
Route::get('/categories', 'CategoriesController@index')->name('categories')->middleware('auth'); //index
Route::post('categories/store', 'CategoriesController@store')->name('storeCategory')->middleware('auth'); //store
Route::put('categories/update/{id}', 'CategoriesController@update')->name('updateCategory')->middleware('auth'); //update
Route::put('categories/delete/{id}', 'CategoriesController@delete')->name('deleteCategory')->middleware('auth'); //update

//Suppliers Routes
Route::get('/suppliers', 'SupplierController@index')->name('suppliers')->middleware('auth'); //index
Route::post('suppliers/store', 'SupplierController@store')->name('storeSupplier')->middleware('auth'); //store
Route::put('suppliers/update/{id}', 'SupplierController@update')->name('updateSupplier')->middleware('auth'); //update
Route::put('suppliers/delete/{id}', 'SupplierController@delete')->name('deleteSupplier')->middleware('auth'); //delete (trash)

//manufacturers Routes
Route::get('/manufacturers', 'ManufacturersController@index')->name('manufacturers')->middleware('auth'); //index
Route::post('manufacturers/store', 'ManufacturersController@store')->name('storeManufacturer')->middleware('auth'); //store
Route::put('manufacturers/update/{id}', 'ManufacturersController@update')->name('updateManufacturer')->middleware('auth'); //update
Route::put('manufacturers/delete/{id}', 'ManufacturersController@delete')->name('deleteManufacturer')->middleware('auth'); //update

//Costumer routes´
Route::get('/customers', 'CustomerController@index')->name('customers')->middleware('auth'); //index view
Route::post('customer/store', 'CustomerController@store')->name('makeCostumer')->middleware('auth'); //store
Route::put('customer/update/{id}', 'CustomerController@update')->name('updateCostumer')->middleware('auth'); //update
Route::put('customer/delete/{id}', 'CustomerController@delete')->name('deleteCostumer')->middleware('auth'); //delete (trash)
//Route::delete('customer/remove/{id}', 'CostumerController@destroy')->name('deleteCostumer')->middleware('auth');

//Sales Routes
Route::get('/sales', 'SaleController@index')->name('sales')->middleware('auth');
Route::get('sales/create', 'SaleController@create')->name('addSale')->middleware('auth');
Route::post('sales/create/store', 'SaleController@store')->name('storeSale')->middleware('auth');
Route::get('sales/invoice/{id}', 'SaleController@invoice')->name('invoice')->middleware('auth');

//Purchases
Route::get('/purchases', 'PurchaseController@index')->name('purchases')->middleware('auth');
Route::get('purchases/create', 'PurchaseController@create')->name('addPurchase')->middleware('auth');
Route::post('purchases/create/makePurchase', 'PurchaseController@store')->name('createPurchase')->middleware('auth');
Route::get('purchase/create/getlist', 'PurchaseController@GetList')->name('getList')->middleware('auth');

//Kardex
Route::get('/kardex', 'KardexController@index')->name('kardex')->middleware('auth');
Route::get('kardex/records/{id}', 'KardexController@records')->name('records')->middleware('auth');
Route::get('kardex/get_records/{id}', 'KardexController@get_records')->name('get_records')->middleware('auth');

//Credits
Route::get('credits/create', 'CreditController@create')->name('addCredit');
Route::post('credits/create/store', 'CreditController@store')->name('storeCredit');

//Others
Route::get('pagination/fetch', 'SaleController@pagination');
Route::get('pagination/fetch/search/{query?}', 'SaleController@search');