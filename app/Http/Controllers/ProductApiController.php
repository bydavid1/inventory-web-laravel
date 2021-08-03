<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductApiController extends Controller
{
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['price', 'photo', 'stock', 'brand', 'category']);

            return DataTables::of($query)
            ->addColumn('actions', '<div>
                        <a role="button" href="{{ route("editProduct", "$id") }}">
                            <i class="badge-circle badge-circle-success bx bx-edit font-medium-1"></i>
                        </a>
                        <a role="button" id="removeProductModalBtn" data-id="{{"$id"}}">
                            <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"></i>
                        </a>
                        <a href="{{ route("showProduct", "$id") }}">
                            <i class="badge-circle badge-circle-info bx bx-arrow-to-right font-medium-1"></i>
                        </a>
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
                    return '<i class="bx bx-check text-success"></i>';
                }else{
                    return '<i class="bx bx-times text-danger"></i>';
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
            $products = Product::select($fields[0])->with($fields[1])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->get();
            return response($products, 200);
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
        }
    }

    public function byId($id, $columns){
        try {
            $fields = json_decode($columns);
            $product = Product::select($fields[0])->with($fields[1])->where('id', $id)->get();
            if ($product->count() > 0) {
                return response($product, 200);
            }else{
                return response('', 204);
            }
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
        }
    }

    /**
     * Sale products pagination with ajax and pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(Request $request)
    {
        if($request->ajax()){
            $products = Product::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
            return response($products, 200);
        }
    }

    /**
     * Search products pagination with ajax and pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function search($query = null)
    {
        if ($query != null) {
            $products = Product::select('id','code','name','stock','description')->with(['first_price', 'first_image'])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->paginate(15);
        }else{
            $products = Product::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        }

        return response($products, 200);
    }
}
