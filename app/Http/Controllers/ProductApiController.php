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
            ->addColumn('actions', 'components.products.actions')
            ->addColumn('prices', fn (Product $product) => $product->price ? $product->price->price_w_tax : "") //Make sure there is at least one price registered
            ->addColumn('photo', fn (Product $product) => '<img class="img-round" src="'.$product->photo?->source.'" style="max-height: 40px; max-width: 50px;"/>')
            ->editColumn('stock', fn (Product $product) => $product->stock()->where('branch_id', 1)->first()->pivot->stock)
            ->editColumn('brand', fn (Product $product) => $product->brand->name)
            ->editColumn('category', fn (Product $product) => $product->category->name)
            ->editColumn('is_available', 'components.products.available')
            ->rawColumns(['actions', 'photo', 'is_available'])
            ->make();
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
            $products = Product::has('price')
                ->select($fields[0])
                ->with($fields[1])
                ->where("code", "like", "%". $query ."%")
                ->orWhere("name", "like", "%". $query ."%")
                ->get();
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
