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
use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Product;
use App\Models\Supplier;
use Exception;

class ProductController extends Controller
{

    private $photo_default = "assets/media/photo_default.png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/home", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["name" => "Productos y servicios"]
        ];

        return view('pages.products', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $breadcrumbs = [
            ["link" => "/home", "name" => "Inicio"],
            ["link" => "#", "name" => "Inventario"],
            ["link" => "#", "name" => "Productos"],
            ["name" => "Crear"]
        ];

        $categories = Category::select(['id','name'])->where('is_available', 1)->get();
        $suppliers = Supplier::select(['id','name'])->where('is_available', 1)->get();
        $brands = Brand::select(['id','name'])->where('is_available', 1)->get();

        return view('pages.product.addProduct', compact(['categories','suppliers', 'brands', 'breadcrumbs']));
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
                    $path = 'storage/' . substr(Storage::disk('public')->put('storage/uploads', $file), 8);
                }else{
                    $path = $this->photo_default;
                }

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
            ["link" => "/home", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["link" => "#", "name" => "Productos y servicios"],
            ["name" => "Alerts"]
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

            //Update image if exist
            if ($request->file('image')) {
                $file = $request->file('image');
                $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);

                if ($savedImage != "") {
                    //Update photo
                    $product->photo()->update([
                        'source' => $path
                    ]);
                    //Delete old photo
                    if ($savedImage != $this->photo_default) {
                        $imageFullPath = public_path() . $savedImage;
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
        }
    }

    /**
     * Move to trash
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $product = Product::find($id);

            $product->delete();

            return response()->json(["message" => "Eliminado correcto"], 200);

        } catch (Exception $th) {
            return response()->json(["message" => "Ocurrió un error al eliminar"], 500);
        }
    }
}
