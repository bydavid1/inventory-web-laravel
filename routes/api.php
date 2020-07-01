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


Route::get('products', 'ProductController@getRecords');

Route::get('categories', function (){
   return datatables()->eloquent(App\Categories::query())
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fas fa-trash" style="color: white"></i></button>
                  </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('suppliers', 'SupplierController@getRecords');

Route::get('manufacturers',  'ManufacturersController@getItems');

Route::get('manufacturers/{id}', 'ManufacturersController@show');

Route::get('costumers', function(){
   return datatables()->eloquent(App\Costumers::query())
      ->addColumn('actions', '<div class="btn-group float-right">
      <button type="button" class="btn btn-danger" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-edit" style="color: white"></i></button>
      <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
      </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('costumers/search/{query}', function($query){
      $result = App\Costumers::select('id', 'name', 'nit')->where('name', 'like', "%". $query ."%")->get();

      if ($result->count() > 0) {
         return response()->json(['success' => true, 'data' => $result], 200);
      }else{
         return response()->json(['success' => false, 'data' => null], 200);
      }
});

Route::get('costumers/{id}', function($id){
   return datatables()->eloquent(App\Costumers::where('id', $id))
      ->toJson();
});

Route::get('products/order/{id}', function ($id){
   return datatables()->eloquent(App\Products::where('id', $id))
      ->toJson();
});

Route::get('products/order/code/{code}', function ($code){
      $products = App\Products::where('code', $code)->firstOrFail();
      if ($products->count() > 0) {
         return response()->json(['success' => true, 'product' => $products], 200);
      }else{
         return response()->json(['success' => false, 'product' => null], 200);
      }
});

Route::get('products/order/search/{query}', function ($query){
   $products = App\Products::where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->get();
   if ($products->count() > 0) {
      return response()->json(['success' => true, 'products' => $products], 200);
   }else{
      return response()->json(['success' => false, 'products' => null], 200);
   }
});


Route::get('sales', function(){
   return datatables()->eloquent(App\Sales::query())
      ->addColumn('actions', '<div class="btn-group float-right">
      <button type="button" class="btn btn-info" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-eye" style="color: white"></i></button>
      <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
      <a type="button" class="btn btn-danger" href="{{ route("invoice", "$id") }}"><i class="fas fa-file-pdf" style="color: white"></i></a>
      </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('products/kardex', function (){
   return datatables()->eloquent(App\Products::select('products.id','products.image','products.code','products.name')->where('products.is_deleted', 0))
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-info" href="{{ route("records", "$id") }}"><i class="fas fa-task" style="color: white"></i>Ver registros</a>
                  </div>')
      ->addColumn('photo', '<img class="img-round" src="{{ asset("$image") }}" style="max-height:50px; max-width:70px;"/>')
      ->rawColumns(['actions', 'photo'])
      ->toJson();
});