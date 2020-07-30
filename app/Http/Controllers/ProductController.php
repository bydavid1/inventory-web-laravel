<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use App\Products;
use App\Prices;
use App\Images;
use App\Purchase_prices;
use App\Categories;
use App\Suppliers;
use App\Manufacturers;
use App\Kardex;

class ProductController extends Controller
{

    private $photo_default = "media/photo_default.png";

     /**
     * Api
     *
     * @return \Illuminate\Http\Response
     */

    public function getRecords()
    {
        $query = Products::select('products.id','products.code','products.name','products.is_available','products.type','products.stock', 'suppliers.name as name_supplier', 'categories.name as name_category')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->with(['first_price', 'first_image'])
        ->where('products.is_deleted', '0');
        
        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
                    <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fa fa-edit" style="color: white"></i></a>
                    <button type="button" class="btn btn-warning" id="removeProductModalBtn" data-id="{{"$id"}}"><i class="fa fa-trash" style="color: white"></i></button>
                    <a type="button" class="btn btn-info" href="{{ route("showProduct", "$id") }}"><i class="fa fa-eye" style="color: white"></i></a>
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
                        return '<i class="fa fa-check text-success"></i>';
                    }else{
                        return '<i class="fa fa-times text-danger"></i>';
                    }
        })
        ->rawColumns(['actions', 'photo', 'is_available'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();
        $providers = Suppliers::select(['id','name'])->where('is_available', 1)->get();
        $manufacturers = Manufacturers::select(['id','name'])->where('is_available', 1)->get();
        //->where('is_available', 1);
        return view('product.addProduct', compact(['categories','providers', 'manufacturers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $path = '';

            if ($request->file('image')) {
                $file = $request->file('image');
                $path = Storage::disk('public')->put('uploads', $file);
            }else{
                $path = $this->photo_default;
            }
            
            $new = new Products;
            $new->code = $request->code;
            $new->name = $request->name;
            $new->description = $request->description;
            $new->supplier_id = $request->provider_id;
            $new->category_id = $request->category_id;
            $new->manufacturer_id = $request->manufacturer_id;
            $new->stock = $request->quantity;
            $new->low_stock_alert = 1;
            $new->type = $request->type;
            $new->is_available = $request->is_available;
            $new->is_deleted = 0;

            if ($new->save()) {

                for ($i=1; $i <= 4; $i++) { 
                    $prices = new Prices;
                    $prices->product_id = $new->id;
                    $prices->price = $request->{'price'.$i};
                    $prices->utility = $request->{'utility'.$i};
                    $prices->tax_id = 1;
                    $prices->price_incl_tax = $request->{'price'.$i};
                    $prices->save();
                }
        
                $images = new Images;
                $images->src = $path;
                $images->product_id = $new->id;
                $images->type = 'principal';
                $images->save();

                $purchase = new Purchase_prices;
                $purchase->product_id = $new->id;
                $purchase->value = $request->purchase;
                $purchase->save();
        
                $kardex = new Kardex;
                $kardex->tag = "Ingreso al inventario";
                $kardex->product_id = $new->id;
                $kardex->quantity =  $new->stock;
                $kardex->difference = "- $" . $request->purchase * $new->stock;
                $kardex->unit_price = $request->purchase;
                $kardex->total = $request->purchase * $new->stock;
                $kardex->save();

                return response()->json(['success'=>'true', 'message'=>'Producto guardado'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::findOrFail($id);

        return view('product.showProduct', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();;
        $suppliers = Suppliers::select(['id','name'])->where('is_available', 1)->get();;
        $product = Products::findOrfail($id)->with(['prices','images']);
        return view('product.editProduct', compact(['product', 'categories', 'suppliers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){ 
        $product = Products::find($id);
        //Salvo el path de la imagen por si luego es necesario eliminarlo
        $savedImage = $product->image;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->provider_id = $request->provider_id;
        $product->category_id = $request->category_id;
        $product->purchase = $request->purchase;
        $product->quantity = $request->quantity;
        $product->type = $request->type;
        $product->price1 = $request->price1;
        $product->price2 = $request->price2;
        $product->price3 = $request->price3;
        $product->price4 = $request->price4;
        $product->utility1 = $request->utility1;
        $product->utility2 = $request->utility2;
        $product->utility3 = $request->utility3;
        $product->utility4 = $request->utility4;
        $product->is_available = $request->is_available;
        $product->is_deleted = 0;
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->put('uploads', $file);
            $product->image = $path;
        }
        $product->save();
        if ($request->file('image')) {
            if ($savedImage != $this->photo_default) {
                unlink($savedImage);
            }
        }

        return back()->with('mensaje', 'Registro actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->input('id_product');
        
        $product = Products::findOrFail($id);
        $product->delete();

        return back()->with('mensaje', "Eliminado correctamente");
    }
}
