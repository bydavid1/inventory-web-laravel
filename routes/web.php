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

Route::get('/product', 'ProductController@index')->name('products');
Route::get('product/create', 'ProductController@create')->name('addProduct');
Route::get('product/{id}/edit', 'ProductController@edit')->name('editProduct');
Route::post('product/show/{id}', 'ProductController@show')->name('showProduct');
Route::get('product/delete/{id}', 'ProductController@destroy')->name('deleteProduct');