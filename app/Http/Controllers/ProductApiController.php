<?php

namespace App\Http\Controllers;

use App\Products;
use Exception;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function getRecords()
    {
        $query = Products::select('products.id','products.code','products.name','products.is_available','products.type','products.stock', 'suppliers.name as name_supplier', 'categories.name as name_category')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->with(['first_price', 'first_image'])
        ->where('products.is_deleted', '0');

        return datatables()->eloquent($query)
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
        ->addColumn('photo', function($products){
                    $path = asset($products->first_image->src);
                        return '<img class="img-round" src="'.$path.'"  style="max-height:50px; max-width:70px;"/>';
        })
        ->addColumn('prices', function($products){
                     //Make sure there is at least one price registered
                        return "$".$products->first_price->price_incl_tax;
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

    public function byCode($code, $columns)
    {
        $fields = json_decode($columns);
        $products = Products::select($fields[0])->with($fields[1])->where('code', $code)->get();
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
            $products = Products::select($fields[0])->with($fields[1])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->get();
            return response($products, 200);
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
        }
    }

    public function byId($id, $columns){
        try {
            $fields = json_decode($columns);
            $product = Products::select($fields[0])->with($fields[1])->where('id', $id)->get();
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
            $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
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
            $products = Products::select('id','code','name','stock','description')->with(['first_price', 'first_image'])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->paginate(15);
        }else{
            $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        }

        return response($products, 200);
    }
}
