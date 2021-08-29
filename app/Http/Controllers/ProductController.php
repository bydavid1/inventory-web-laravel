<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\Prices;
use App\Models\Images;
use App\Models\Purchase_prices;
use App\Models\Categories;
use App\Http\Requests\StoreProduct;
use App\Models\Suppliers;
use App\Models\Manufacturers;
use App\Models\Kardex;
=======
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Product;
use App\Models\Supplier;
>>>>>>> database
use Exception;

class ProductController extends Controller
{

<<<<<<< HEAD
    private $photo_default = "default";
=======
    private $photo_default = "photo_default.png";
>>>>>>> database

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        return view('pages.products', ['breadcrumbs'=>$breadcrumbs]);
=======
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["name" => "Productos y servicios"]
        ];

        return view('pages.products', ['breadcrumbs' => $breadcrumbs]);
>>>>>>> database
    }

    /**
     * Show the form for creating a new resource.
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return View
>>>>>>> database
     */
    public function create()
    {
        $breadcrumbs = [
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();
        $providers = Suppliers::select(['id','name'])->where('is_available', 1)->get();
        $manufacturers = Manufacturers::select(['id','name'])->where('is_available', 1)->get();
        //->where('is_available', 1);
        return view('pages.product.addProduct', compact(['categories','providers', 'manufacturers', 'breadcrumbs']));
=======
            ["link" => "/", "name" => "Inicio"],
            ["link" => "#", "name" => "Inventario"],
            ["link" => "#", "name" => "Productos"],
            ["name" => "Crear"]
        ];

        $categories = Category::select(['id','name'])->where('is_available', 1)->get();
        $suppliers = Supplier::select(['id','name'])->where('is_available', 1)->get();
        $brands = Brand::select(['id','name'])->where('is_available', 1)->get();

        return view('pages.product.addProduct', compact(['categories','suppliers', 'brands', 'breadcrumbs']));
>>>>>>> database
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
<<<<<<< HEAD

            if ($request->validated()) {
                $path = '';

=======
            if ($request->validated()) {
                $path = '';


>>>>>>> database
                if ($request->file('image')) {
                    $file = $request->file('image');
                    $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);
                }else{
                    $path = $this->photo_default;
                }

<<<<<<< HEAD
                $new = new Products;
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
                        $prices = new Prices;
                        $prices->product_id = $new->id;
                        $prices->price = $key['price'];
                        $prices->utility = $key['utility'];
                        $prices->tax_id = 1;
                        $prices->price_incl_tax = $key['price'];
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
                    $kardex->type_id = 1; //Ingreso a inventario
                    $kardex->product_id = $new->id;
                    $kardex->quantity =  $new->stock;
                    $kardex->unit_price = $request->purchase;
                    $kardex->value = $request->purchase * $new->stock;
                    $kardex->final_unit_value = $request->purchase;
                    $kardex->final_stock = $new->stock;
                    $kardex->final_value = $request->purchase * $new->stock;
                    $kardex->save();

                    return response()->json(['success'=>'true', 'message'=>'Producto guardado'], 200);
                }
=======
                $is_service = $request->has('is_service');

                $product = new Product;
                $product->code = $request->code;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->is_service = $is_service;
                $product->brand_id = $request->brand_id;
                $product->unit_measure_id = 1; //temporally default
                $product->category_id = $request->category_id;
                $product->is_available = $request->is_available;
                $product->save();

                /**** Saving supplier ****/
                $product->suppliers()->attach($request->supplier_id);

                /**** Saving stock ****/
                $product->stock()->attach(1, [
                    "stock" => $is_service ? 1 :  $request->stock,
                    "low_stock" => $is_service ? 1 : 2 //temporaly default
                ]);

                /**** Saving prices ****/
                $prices = array();

                $temporalDefaultTax = 0.13; ///Its temporal!!

                foreach ($request->prices as $item) {
                    $price = new Price([
                        "branch_id" => 1,
                        "price" => $item['price'],
                        "price_w_tax" => ($item['price'] * $temporalDefaultTax) + $item['price'],
                        "utility" => $item['utility'],
                        "tax_id" => 1
                    ]);

                    array_push($prices, $price);
                }

                $product->prices()->saveMany($prices);

                /**** Saving photo ****/

                $product->photo()->save(new Photo([
                    "source" => $path
                ]));

                /**** Creating kardex report ****/

                $kardexReport = new KardexReport();
                $kardexReport->start_date = date('Y-m-d');

                $product->kardexReport()->save($kardexReport);

                $kardexItem = new KardexItem();
                $kardexItem->product_id = $product->id;
                $kardexItem->is_initial = 1;
                $kardexItem->quantity =  $request->stock;
                $kardexItem->unit_value = $request->purchase;
                $kardexItem->value = $request->purchase * $request->stock;
                $kardexItem->final_stock = $request->stock;
                $kardexItem->final_unit_value = $request->purchase;
                $kardexItem->final_value = $request->purchase * $request->stock;

                $kardexReport->records()->save($kardexItem);

                return response()->json(['message' => "Producto guardado"], 201);
>>>>>>> database
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
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $product = Products::findOrFail($id);
=======
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["link" => "#", "name" => "Productos y servicios"],
            ["name" => "Alerts"]
        ];
        $product = Product::findOrFail($id);
>>>>>>> database

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
<<<<<<< HEAD
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        $categories = Categories::select(['id','name'])->where('is_available', '1')->get();
        $suppliers = Suppliers::select(['id','name'])->where('is_available', '1')->get();
        $manufacturers = Manufacturers::select(['id','name'])->where('is_available', '1')->get();
        $product = Products::with(['prices' => function($query){
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
=======
        $categories = Category::select(['id','name'])->where('is_available', '1')->get();
        $brands = Brand::select(['id','name'])->where('is_available', '1')->get();

        $product = Product::find($id);

        $breadcrumbs = [
            ["link" => route("home"), "name" => "Home"],
            ["link" => route("products"), "name" => "Inventario"],
            ["link" => route("products"), "name" => "Productos y servicios"],
            ["link" => "#", "name" => $product->name],
            ["name" => "Editar"]
        ];

        //return response($product, 200);
        return view('pages.product.editProduct', compact(['product', 'categories', 'brands', 'breadcrumbs']));
>>>>>>> database
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
<<<<<<< HEAD
                'name' => 'required',
                'stock' => 'required',
                'purchase' => 'required'
            ]);

            $product = Products::find($id);
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
=======
                'name' => 'required'
            ]);

            $product = Product::find($id);
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->is_available = $request->is_available;

            //Salvo el path de la imagen por si luego es necesario eliminarlo
            $savedImage = "";
            if ($product->photo) {
                $savedImage = $product->photo->source;
            }
>>>>>>> database

            //Update image if exist
            if ($request->file('image')) {
                $file = $request->file('image');
                $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);
<<<<<<< HEAD
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
=======

                if ($savedImage != "") {
                    //Update photo
                    $product->photo()->update([
                        'source' => $path
                    ]);
                    //Delete old photo
                    if ($savedImage != $this->photo_default) {
                        $imageFullPath = public_path() . "/storage/" . $savedImage;
                        if (file_exists($imageFullPath)) {
                            unlink($imageFullPath);
                        }
                    }
                } else {
                    //Create new photo if old is empty
                    $product->photo()->save(new Photo([
                        "source" => $path
                    ]));
                }
            }


            $product->save();

            return response()->json(['message' => "Producto actualizado"], 201);

        } catch (Exception $th) {
            return response()->json(['message' => "Error: " . $th->getMessage()], 500);
>>>>>>> database
        }
    }

    /**
     * Move to trash
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function delete(Request $request)
    {
        $product = Products::find($request->identifier);
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

        $product = Products::findOrFail($id);
        $product->delete();

        return back()->with('mensaje', "Eliminado correctamente");
=======
    public function delete($id)
    {
        try {
            $product = Product::find($id);

            $product->delete();

            return response()->json(["message" => "Eliminado correcto"], 200);

        } catch (Exception $th) {
            return response()->json(["message" => "Ocurrió un error al eliminar"], 500);
        }
>>>>>>> database
    }
}
