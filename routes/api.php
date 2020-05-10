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
   return datatables()->eloquent(App\Products::select('products.id','products.image','products.code','products.name','products.price1','products.is_available','products.type','products.quantity', 'providers.name as name_prov', 'categories.name as name_categ')->join('providers', 'products.provider_id', '=', 'providers.id')->join('categories', 'products.category_id', '=', 'categories.id')->where('products.is_deleted', 0))
      ->addColumn('actions', '<div class="btn-group float-right">
                  <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                  <button type="button" class="btn btn-warning" id="removeProductModalBtn" data-id="{{"$id"}}"><i class="fas fa-trash" style="color: white"></i></button>
                  <a type="button" class="btn btn-info" href="{{ route("showProduct", "$id") }}"><i class="fas fa-eye" style="color: white"></i></a>
                  </div>')
      ->addColumn('photo', '<img class="img-round" src="{{ asset("$image") }}" style="max-height:50px; max-width:70px;"/>')
      ->rawColumns(['actions', 'photo'])
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

Route::get('costumers', function(){
   return datatables()->eloquent(App\Costumers::query())
      ->addColumn('actions', '<div class="btn-group float-right">
      <button type="button" class="btn btn-danger" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-edit" style="color: white"></i></button>
      <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
      </div>')
      ->rawColumns(['actions'])
      ->toJson();
});

Route::get('costumers/{id}', function($id){
   return datatables()->eloquent(App\Costumers::where('id', $id))
      ->toJson();
});

Route::get('products/order', function (){
   return datatables()->eloquent(App\Products::select('products.id','products.image','products.code','products.name','products.price1', 'products.price2', 'products.price3', 'products.price4', 'products.quantity', 'providers.name as name_prov', 'categories.name as name_categ')->join('providers', 'products.provider_id', '=', 'providers.id')->join('categories', 'products.category_id', '=', 'categories.id')->where('products.is_deleted', 0))
      ->addColumn('actions', '<div class="btn-group float-center">
                  <button type="button" class="btn btn-primary"  onclick="add({{ $id }})"><i class="fas fa-plus" style="color: white"></i></button>
                  <button type="button" class="btn btn-default"  onclick="view({{ $id }})"><i class="fas fa-external-link-alt"></i></button>')
      ->addColumn('photo', '<img class="img-round" src="{{ asset("$image") }}" style="max-height:50px; max-width:70px;"/>')
      ->addColumn('price', '<div class="input-group input-group-sm"><div class="input-group-prepend">
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        ${{ $price1 }}
      </button>
      <ul class="dropdown-menu">
        <li class="dropdown-item" onclick="changeprice({{ $id }}, {{ $price1 }})">${{ $price1 }}</li>
        <li class="dropdown-item" onclick="changeprice({{ $id }}, {{ $price2 }})">${{ $price2 }}</li>
        <li class="dropdown-item" onclick="changeprice({{ $id }}, {{ $price3 }})">${{ $price3 }}</li>
        <li class="dropdown-item" onclick="changeprice({{ $id }}, {{ $price4 }})">${{ $price4 }}</li>
      </ul>
     </div><input type="text" class="form-control" value="{{ $price1 }}" id="precio_venta_{{ $id }}"/></div>')
      ->addColumn('custom_quantity', '<div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">{{ $quantity }}</span></div><input type="text" class="form-control" value="1" id="cantidad_{{ $id }}"/></div>')
      ->rawColumns(['actions', 'photo', 'price', 'custom_quantity'])
      ->toJson();
});

Route::get('products/order/{id}', function ($id){
   return datatables()->eloquent(App\Products::where('id', $id))
      ->toJson();
});

Route::get('sales', function(){
   return datatables()->eloquent(App\Sales::query())
      ->addColumn('actions', '<div class="btn-group float-right">
      <button type="button" class="btn btn-info" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-eye" style="color: white"></i></button>
      <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
      </div>')
      ->rawColumns(['actions'])
      ->toJson();
});