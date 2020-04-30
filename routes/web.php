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

//Product Routes
Route::get('/product', 'ProductController@index')->name('products');
Route::get('product/create', 'ProductController@create')->name('addProduct');
Route::post('/makeProduct', 'ProductController@make')->name('makeProduct');
Route::get('product/{id}/edit', 'ProductController@edit')->name('editProduct');
Route::put('updateProduct/{id}', 'ProductController@update')->name('updateProduct');
Route::get('product/show/{id}', 'ProductController@show')->name('showProduct');
Route::delete('product/delete', 'ProductController@destroy')->name('deleteProduct');

//Categories Routes
Route::get('/categories', 'CategoriesController@index')->name('categories');
Route::get('categories/create', 'CategoriesController@create')->name('addCategory');
Route::post('/makeCategory', 'CategoriesController@make')->name('makeCategory');

//Providers Routes
Route::get('/providers', 'ProviderController@index')->name('providers');
Route::get('providers/create', 'ProviderController@create')->name('addProvider');
Route::post('/makeProvider', 'ProviderController@make')->name('makeProvider');

//Costumer routes´
Route::get('/costumers', 'CostumerController@index')->name('costumers');
Route::get('/costumers/create', 'CostumerController@create')->name('addCostumers');
route::post('/makeCostumer', 'CostumerController@store')->name('makeCostumer');