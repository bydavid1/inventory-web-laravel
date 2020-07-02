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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register', function(){
    return view('auth.register');
})->name('register');

//Product Routes
Route::get('/product', 'ProductController@index')->name('products')->middleware('auth');
Route::get('product/create', 'ProductController@create')->name('addProduct')->middleware('auth');
Route::post('/makeProduct', 'ProductController@store')->name('makeProduct')->middleware('auth');
Route::get('product/{id}/edit', 'ProductController@edit')->name('editProduct')->middleware('auth');
Route::put('updateProduct/{id}', 'ProductController@update')->name('updateProduct')->middleware('auth');
Route::get('product/show/{id}', 'ProductController@show')->name('showProduct')->middleware('auth');
Route::delete('product/delete', 'ProductController@destroy')->name('deleteProduct')->middleware('auth');

//Categories Routes
Route::get('/categories', 'CategoriesController@index')->name('categories')->middleware('auth');
Route::post('/makeCategory', 'CategoriesController@store')->name('makeCategory')->middleware('auth');

//Suppliers and manufacturers Routes
Route::get('/suppliers', 'SupplierController@index')->name('suppliers')->middleware('auth');
Route::get('/manufacturers', 'ManufacturersController@index')->name('manufacturers')->middleware('auth');
Route::post('/storeSupplier', 'SupplierController@store')->name('storeSupplier')->middleware('auth');
Route::post('/storeManufacturer', 'ManufacturersController@store')->name('storeManufacturer')->middleware('auth');
Route::put('/editmanufacturer/{id}', 'ManufacturersController@update')->name('editManufacturer')->middleware('auth');

//Costumer routes´
Route::get('/costumers', 'CostumerController@index')->name('costumers')->middleware('auth');
Route::get('/costumer/create', 'CostumerController@create')->name('addCostumers')->middleware('auth');
route::post('/makeCostumer', 'CostumerController@store')->name('makeCostumer')->middleware('auth');
route::put('updateCostumer/{id}', 'CostumerController@update')->name('updateCostumer')->middleware('auth');
Route::delete('costumer/delete/{id}', 'CostumerController@destroy')->name('deleteCostumer')->middleware('auth');

//Sales Routes
Route::get('/sales', 'SaleController@index')->name('sales')->middleware('auth');
Route::get('sales/create', 'SaleController@create')->name('addSale')->middleware('auth');
Route::post('/makeinvoice', 'SaleController@store')->name('makeInvoice')->middleware('auth');
Route::post('/save', 'SaleController@save')->name('save');
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
Route::post('credits/create/buildCredit', 'CreditController@store')->name('createCredit');