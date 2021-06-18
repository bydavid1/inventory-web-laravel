<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Product;
use App\Models\Supplier;
use Exception;

class ProductController extends Controller
{

    private $photo_default = "default.png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Inventario"],["name" => "Productos y servicios"]
        ];
        return view('pages.products', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $categories = Category::select(['id','name'])->where('is_available', 1)->get();
        $providers = Supplier::select(['id','name'])->where('is_available', 1)->get();
        $manufacturers = Brand::select(['id','name'])->where('is_available', 1)->get();
        //->where('is_available', 1);
        return view('pages.product.addProduct', compact(['categories','providers', 'manufacturers', 'breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        try {

            if ($request->validated()) {
                $path = '';

                if ($request->file('image')) {
                    $file = $request->file('image');
                    $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);
                }else{
                    $path = $this->photo_default;
                }

                $new = new Product;
                $new->code = $request->code;
                $new->name = $request->name;
                $new->description = $request->description;
                $new->supplier_id = $request->provider_id;
                $new->category_id = $request->category_id;
                $new->manufacturer_id = $request->manufacturer_id;
                $new->stock = $request->stock;
                $new->low_stock_alert = 1;
                $new->type = $request->type;
                $new->is_available = $request->is_available;
                $new->is_deleted = 0;

                if ($new->save()) {

                    foreach ($request->prices as $key) {
                        $prices = new Price;
                        $prices->product_id = $new->id;
                        $prices->price = $key['price'];
                        $prices->utility = $key['utility'];
                        $prices->tax_id = 1;
                        $prices->price_incl_tax = $key['price'];
                        $prices->save();
                    }

                    $photo = new Photo;
                    $photo->source = $path;
                    $photo->product_id = $new->id;
                    $photo->type = 'principal';
                    $photo->save();

                    // $purchase = new Purchase_prices;
                    // $purchase->product_id = $new->id;
                    // $purchase->value = $request->purchase;
                    // $purchase->save();

                    // $kardex = new Kardex;
                    // $kardex->type_id = 1; //Ingreso a inventario
                    // $kardex->product_id = $new->id;
                    // $kardex->quantity =  $new->stock;
                    // $kardex->unit_price = $request->purchase;
                    // $kardex->value = $request->purchase * $new->stock;
                    // $kardex->final_unit_value = $request->purchase;
                    // $kardex->final_stock = $new->stock;
                    // $kardex->final_value = $request->purchase * $new->stock;
                    // $kardex->save();

                    return response()->json(['success'=>'true', 'message'=>'Producto guardado'], 200);
                }
            }
        } catch (Exception $e) {
            return response()->json(['message'=> $e->getMessage()], 500);
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
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $product = Product::findOrFail($id);

        return view('pages.product.showProduct', compact('product', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $categories = Category::select(['id','name'])->where('is_available', '1')->get();
        $suppliers = Supplier::select(['id','name'])->where('is_available', '1')->get();
        $manufacturers = Brand::select(['id','name'])->where('is_available', '1')->get();
        $product = Product::with(['prices' => function($query){
            $query->select('id','product_id','price','price_incl_tax','utility');
        },
        'images' => function($query){
            $query->select('id','product_id','src');
        },
        'purchase_prices' => function($query){
            $query->select('id','product_id','value');
        }])
        ->where('id', $id)->get();

        //return response($product, 200);
        return view('pages.product.editProduct', compact(['product', 'categories', 'suppliers', 'manufacturers', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        try {
            $request->validate([
                'code' => 'required',
                'name' => 'required',
                'stock' => 'required',
                'purchase' => 'required'
            ]);

            $product = Product::find($id);
            $savedImage = $product->first_image->src; //Salvo el path de la imagen por si luego es necesario eliminarlo
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->supplier_id = $request->provider_id;
            $product->category_id = $request->category_id;
            $product->stock = $request->stock;
            $product->type = $request->type;
            $product->is_available = $request->is_available;

            //Update purchase_prices
            $product->first_purchase_price()->update([
                'value' => $request->purchase
            ]);

            //Update prices
            $prices = $product->prices();
            $prices->each(function($item) use($request){
                $id = $item->id;
                $item->update(array('price' => $request->{'price'.$id}, 'utility' => $request->{'utility'.$id}));
            });

            //Update image if exist
            if ($request->file('image')) {
                $file = $request->file('image');
                $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);
                $product->first_image()->update([
                    'src' => $path
                ]);
            }

            $product->save();

            if ($request->file('image')) {
                if ($savedImage != $this->photo_default) {
                    unlink($savedImage);
                }
            }

        return back()->with('mensaje', 'Registro actualizado exitosamente');

        } catch (Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Move to trash
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $product = Product::find($request->identifier);
        $product->is_deleted = 1;
        $product->save();

        if ($product->save()) {
            return back()->with('mensaje', "Se movió a la papelera");
        }else{
            return back()->with('error', "No se pudo eliminar");
        }
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

        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('mensaje', "Eliminado correctamente");
    }
}
