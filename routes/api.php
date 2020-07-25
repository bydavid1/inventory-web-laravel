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
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fa fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fa fa-trash" style="color: white"></i></button>
                  </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('suppliers', 'SupplierController@getRecords');

Route::get('manufacturers',  'ManufacturersController@getItems');

Route::get('manufacturers/{id}', 'ManufacturersController@show');

Route::get('customers', function(){
   return datatables()->eloquent(App\Costumers::where('is_deleted', '0'))
      ->addColumn('actions', '<div class="btn-group float-right">
      <button type="button" class="btn btn-success" data-toggle="modal" onclick="update({{"$id"}})" data-target="#editCostumer"><i class="fa fa-edit" style="color: white"></i></button>
      <button type="button" class="btn btn-warning" onclick="remove({{"$id"}})"><i class="fa fa-trash" style="color: white"></i></button>
      </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('customer/{id}', 'CostumerController@show');

Route::get('costumers/search/{query}', function($query){
      $result = App\Costumers::select('id', 'name', 'nit')->where('name', 'like', "%". $query ."%")->get();

      if ($result->count() > 0) {
         return response()->json(['success' => true, 'data' => $result], 200);
      }else{
         return response()->json(['success' => false, 'data' => null], 200);
      }
});

Route::get('products/order/{id}', function ($id){
   return datatables()->eloquent(App\Products::where('id', $id))
      ->toJson();
});

Route::get('products/order/code/{code}', function ($code){
      $products = App\Products::where('code', $code)->with('first_price')->get();
      if ($products->count() > 0) {
         return response()->json(['success' => true, 'product' => $products], 200);
      }else{
         return response()->json(['success' => false, 'product' => null], 200);
      }
});

Route::get('products/order/search/{query}', function ($query){
   $products = App\Products::select('id','code','name','stock','description')->with(['prices', 'images'])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->get();
   if ($products->count() > 0) {
      return response()->json(['success' => true, 'products' => $products], 200);
   }else{
      return response()->json(['success' => false, 'products' => null], 200);
   }
});


Route::get('sales', 'SaleController@getRecords');

Route::get('purchases', 'PurchaseController@getRecords');

Route::get('products/kardex', 'KardexController@getProductList');