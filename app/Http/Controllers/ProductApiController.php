<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductApiController extends Controller
{
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['price', 'photo', 'stock', 'brand', 'category']);

            return DataTables::of($query)
            ->addColumn('actions', '
                        <div class="btn-group dropdown mb-1">
                            <a role="button" href="{{ route("editProduct", "$id") }}" class="btn btn-secondary">Editar</a>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-reference="parent">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                <button class="dropdown-item" onclick="getPrices({{"$id"}})">Editar precios</button>
                                <button class="dropdown-item" onclick="remove({{"$id"}})">Eliminar</button>
                                <a class="dropdown-item" href="{{ route("showProduct", "$id") }}">Ver producto</a>
                            </div>
                        </div>')
            ->addColumn('prices', function($products){
                //Make sure there is at least one price registered
                if ($products->price != null) {
                return "$". $products->price->price_w_tax;
                }else {
                    return "";
                }
            })
            ->addColumn('photo', function($products){
                if ($products->photo != null) {

                    $path = "";

                    if ($products->photo->source == "photo_default.png") {
                        $path = asset('assets/media/' . $products->photo->source);
                    } else {
                        $path = asset('storage/' . $products->photo->source);
                    }

                    return '<img class="img-round" src="'.$path.'" style="max-height:40px; max-width:50px;"/>';
                } else {
                    return '<img class="img-round" src="" style="max-height:50px; max-width:70px;"/>';
                }
            })
            ->editColumn('stock', function($products) {
                foreach ($products->stock as $i) {
                    return $i->pivot->stock;
                }
            })
            ->editColumn('brand', function($products){
                return $products->brand->name;
            })
            ->editColumn('category', function($products){
                return $products->category->name;
            })
            ->editColumn('is_available', function($products){
                if ($products->is_available == 1) {
                    return '<i class="bx bxs-check-circle text-success"></i>';
                }else{
                    return '<i class="bx bxs-x-circle text-danger"></i>';
                }
            })
            ->rawColumns(['actions', 'photo', 'is_available'])
            ->toJson();
        }
    }

    public function byCode($code, $columns)
    {
        $fields = json_decode($columns);
        $products = Product::select($fields[0])->with($fields[1])->where('code', $code)->get();
        if ($products->count() > 0) {
            return response()->json(['success' => true, 'product' => $products], 200);
        }else{
            return response()->json(['success' => false, 'product' => null], 200);
        }
    }

    public function byQuery($query, $columns)
    {
        try {
            $fields = json_decode($columns);
            $products = Product::has('price')->select($fields[0])->with($fields[1])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->get();
            return response($products, 200);
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
        }
    }

    public function byId($id, $columns){
        try {
            $fields = json_decode($columns);
            $product = Product::select($fields[0])->with($fields[1])->findOrFail($id);

            return response()->json(['product' => $product], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message'=> $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }

    /**
     * Sale products pagination with ajax and pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(Request $request)
    {
        try {
            if($request->ajax()){
                $products = Product::has('price')->whereHas('stock', function(Builder $query) {
                    $query->where('stock.stock', '>', '0');
                })->with(['photo','stock' => function($query) {
                    $query->select('stock.stock');
                },'price' => function($query) {
                    $query->select('id', 'price_w_tax', 'product_id');
                }])->paginate(15);

                return response($products, 200);
            }
        } catch (Exception $th) {
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Search products pagination with ajax and pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $query = null)
    {

        try {
            if($request->ajax()){
                if ($query != null) {
                    $products = Product::has('price')->whereHas('stock', function(Builder $query) {
                        $query->where('stock.stock', '>', '0');
                    })->with(['photo','stock' => function($query) {
                        $query->select('stock.stock');
                    },'price' => function($query) {
                        $query->select('id', 'price_w_tax', 'product_id');
                    }])
                    ->where("code", "like", "%". $query ."%")
                    ->orWhere("name", "like", "%". $query ."%")->paginate(15);
                }else{
                    $products = Product::has('price')->whereHas('stock', function(Builder $query) {
                        $query->where('stock.stock', '>', '0');
                    })->with(['photo','stock' => function($query) {
                        $query->select('stock.stock');
                    },'price' => function($query) {
                        $query->select('id', 'price_w_tax', 'product_id');
                    }])->paginate(15);
                }

                return response($products, 200);
            }
        } catch (Exception $th) {
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Get all prices
     *
     * @return \Illuminate\Http\Response
     */
    public function prices($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response($product->prices, 200);
        } else {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }
    }

    /**
     * Update prices
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePrices(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            //Updating prices
            $temporalDefaultTax = 0.13; ///Its temporal!!

            foreach ($request->prices as $key => $item) {
                $price = [
                    "price" => $item['price'],
                    "price_w_tax" => ($item['price'] * $temporalDefaultTax) + $item['price'],
                    "utility" => $item['utility'],
                ];
                $product->prices()->updateOrCreate(["id" => $key], $price);
            }

            if ($product->save()) {
                return response()->json(["message" => "Precios actualizados"], 201);
            } else {
                return response()->json(["message" => "Ocurrio un error"], 400);
            }
        } catch (Exception $th) {
            return response()->json(["message" => "Ocurrio un error: " . $th->getMessage()], 500);
        }
    }
}
