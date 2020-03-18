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

Route::get('products', function (){
   return datatables()->eloquent(App\Products::query())
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fas fa-trash" style="color: white"></i></button>
                  <a type="button" class="btn btn-info" href="{{ route("showProduct", "$id") }}"><i class="fas fa-eye" style="color: white"></i></a>
                  </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('categories', function (){
   return datatables()->eloquent(App\Categories::query())
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fas fa-trash" style="color: white"></i></button>
                  </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('providers', function (){
   return datatables()->eloquent(App\Providers::query())
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fas fa-trash" style="color: white"></i></button>
                  </div>')
      ->rawColumns(['actions'])
      ->toJson();
});