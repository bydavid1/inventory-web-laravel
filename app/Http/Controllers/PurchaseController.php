<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\StorePurchase;
use App\Images;
use App\Kardex;
use App\Prices;
use App\Products;
use App\Purchase_prices;
use App\Suppliers;
use App\Purchases;
use App\Purchases_item;
use App\Purchases_items;
use App\Traits\Helpers;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PurchaseController extends Controller
{

    use Helpers;

        /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        $query = Purchases::select('id', 'created_at', 'supplier_id', 'total_quantity', 'subtotal', 'total');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
        <button type="button" class="btn btn-info" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-eye" style="color: white"></i></button>
        <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
        <a type="button" class="btn btn-danger" href="{{ route("invoice", "$id") }}"><i class="fas fa-file-pdf" style="color: white"></i></a>
        </div>')
        ->addColumn('name', function($query){

                $name = Suppliers::select('name')->where('id', $query->supplier_id)->get();
                return $name[0]->name;

        })
        ->editColumn('sub_total', function($query){
            return '$' . $query->subtotal;
        })
        ->editColumn('total', function($query){
            return '$' . $query->total;
        })
        ->rawColumns(['actions', 'invoice_type'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        return \view('pages.purchases', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Compras"],["name" => "Crear nueva"]
        ];
        $categories = Categories::select(['id', 'name'])->where('is_available', 1)->get();
        $suppliers = Suppliers::select(['id', 'name'])->where('is_available', 1)->get();
        //->where('is_available', 1);
        return view('pages.purchases.addPurchase', compact(['categories', 'suppliers', 'breadcrumbs']));
    }

    /**
     * Get product List
     *
     * @return \Illuminate\Http\Response
     */
    public function GetList()
    {
        $list = Products::select(['id', 'name', 'quantity', 'purchase', 'price1'])->get();

        return Datatables::of($list)
            ->addColumn('action', '<div style="display: inline-flex">
            <button class="btn btn-primary btn-sm mr-1" onclick="add({{ $id }})"><i class="fas fa-plus"></i>Agregar</button>
            </div>')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchase $request)
    {
        try {
            $validated = $request->validated();

            if ($validated) {
                            //invoice headers info
            $purchase = new Purchases;
            $purchase->supplier_id = $request->supplierId;
            $purchase->total_quantity = $request->quantityValue;
            $purchase->total = $request->totalValue;
            $purchase->subtotal = $request->subtotalValue;

            if ($purchase->save()) {

                $id = $purchase->id;

                foreach ($request->products as $product) {
                    $purchaseitem = new Purchases_items();

                    $purchaseitem->purchase_id = $id;
                    $purchaseitem->is_new = $product['isNewProduct'];
                    $purchaseitem->quantity = $product['quantity'];
                    $purchaseitem->unit_price = $product['purchase'];
                    $purchaseitem->total = $product['total'];

                    if ($product['isNewProduct'] == true) {

                        //creating new product

                        $newProduct = new Products;
                        $newProduct->code = $product['code'];
                        $newProduct->name = $product['name'];
                        $newProduct->supplier_id = $request->supplierId;
                        $newProduct->category_id = $product['category'];
                        $newProduct->manufacturer_id = '1'; ///<----------Fix this
                        $newProduct->low_stock_alert = '1'; ///<----------Fix this
                        $newProduct->stock = $product['quantity'];
                        $newProduct->type = 1;
                        $newProduct->is_available = 1;
                        $newProduct->is_deleted = 0;
                        $newProduct->save();

                        $prices = new Prices();
                        $prices->product_id = $newProduct->id;
                        $prices->price = $product['price'];
                        $prices->utility = $product['price'] - $product['purchase'];
                        $prices->tax_id = 1;
                        $prices->price_incl_tax = $product['price'];
                        $prices->save();

                        $images = new Images();
                        $images->src = "media/photo_default.png";
                        $images->product_id = $newProduct->id;
                        $images->type = 'principal';
                        $images->save();

                        $purchase = new Purchase_prices();
                        $purchase->product_id = $newProduct->id;
                        $purchase->value = $product['purchase'];
                        $purchase->save();

                        $kardex = new Kardex();
                        $kardex->tag = "Ingreso al inventario";
                        $kardex->product_id = $newProduct->id;
                        $kardex->quantity =  $newProduct->stock;
                        $kardex->difference = "- $" . $purchaseitem->total;
                        $kardex->unit_price = $product['purchase'];
                        $kardex->total = $purchaseitem->total;
                        $kardex->save();

                        $purchaseitem->product_id = $newProduct->id;

                        //Adding to Kardex
                        $this->storedata("new", $newProduct->id, $purchaseitem->quantity, $purchaseitem->unit_price, $purchaseitem->total);
                    } else {

                        $purchaseitem->product_id = $product['id'];
                        //Adding to Kardex
                        $this->storedata("add", $purchaseitem->product_id, $purchaseitem->quantity, $purchaseitem->unit_price, $purchaseitem->total);

                        //Update quantity
                        $product = Products::find($purchaseitem->product_id);

                        // Make sure we've got the Products model
                        if ($product) {
                            $product->stock = ($product->stock + $purchaseitem->quantity);
                            $product->save();
                        }
                    }

                    $purchaseitem->save();
                }


                return response()->json(['message' => 'Factura guardada']);

            }

            return response()->json(['message' => 'Ocurrió un error al registrar la información']);

            }
        } catch (Exception $e) {

            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
