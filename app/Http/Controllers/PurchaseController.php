<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KardexTrait;
use App\Purchases;
use App\Purchases_item;
use App\Products;
use App\Categories;
use App\Providers;
use Yajra\Datatables\Datatables;

class PurchaseController extends Controller
{

    use KardexTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('purchases');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();;
        $providers = Providers::select(['id','name'])->where('is_available', 1)->get();;
        //->where('is_available', 1);
        return view('purchases.add', compact(['categories','providers']));
    }

        /**
     * Get product List
     *
     * @return \Illuminate\Http\Response
     */
    public function GetList()
    {
        $list = Products::select(['id','name','quantity','purchase','price1'])->get();

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
    public function store(Request $request)
    {
        try {
            //invoice headers info
            $purchase = new Purchases;
            $purchase->provider = $request->provider;
            $purchase->quantity = $request->grandquantityvalue;
            $purchase->total = $request->grandtotalvalue;
            $purchase->is_deleted = 0;
    
            if ($purchase->save()) {

            $id = $purchase->id;
            $counter = $request->trCount;

            for ($i=1; $i <= $counter; $i++) { 
                $purchaseitem = new Purchases_item;
                //database and request handlers
                $data = ['pnamevalue', 'pcodevalue', 'status', 'quantityvalue', 'purchasevalue', 'totalvalue'];
                $db = ['product_name', 'product_code', 'status', 'quantity', 'price', 'total'];

                for ($j=0; $j < 6; $j++) { 
                    //Packing item data to -> $purchaseitem
                    $modifier = $data[$j] ."". $i;
                    $dbmodifier = $db[$j];
                    $purchaseitem->$dbmodifier = $request->$modifier;
                }
                $purchaseitem->purchase_id = $id;

                if ($purchaseitem->save()) {

                        //if product == new then save in storage
                    if ($purchaseitem->status == "nuevo") {
                        $utility1 = ($request->purchasevalue . "" . $i) - ($request->price . "" . $i);
                        $newProduct = new Products;
                        $newProduct->code = $purchaseitem->product_code;
                        $newProduct->name = $purchaseitem->product_name;
                        $newProduct->image = "media/photo_default.png";
                        $newProduct->description = "Sin descripción";
                        $newProduct->provider_id = $request->provider . "" . $i;
                        $newProduct->category_id = $request->category . "" . $i;
                        $newProduct->purchase = $purchaseitem->price . "" . $i;
                        $newProduct->quantity = $purchaseitem->quantity . "" . $i;
                        $newProduct->type = 1;
                        $newProduct->price1 = $request->price . "" . $i;
                        $newProduct->price2 = 0.00;
                        $newProduct->price3 = 0.00;
                        $newProduct->price4 = 0.00;
                        $newProduct->utility1 = $utility1;
                        $newProduct->utility2 = 0.00;
                        $newProduct->utility3 = 0.00;
                        $newProduct->utility4 = 0.00;
                        $newProduct->is_available = 0;
                        $newProduct->is_deleted = 0;
                        $newProduct->save();

                        //Adding to Kardex

                        $this->storedata("new", $newProduct->id, $purchaseitem->quantity, $purchaseitem->price, $purchaseitem->total, $id);

                    }else {
                        //Update quantity 
                        $product = Products::select('quantity', 'id')->where('code', $purchaseitem->product_code)->first();
                        $product->quantity = $product->quantity + $purchaseitem->quantity;
                        $product->save();

                        //Adding to Kardex

                        $this->storedata("add", $product->id, $purchaseitem->quantity, $purchaseitem->price, $purchaseitem->total, $id);
                    }

                //Adding $purchaseitems to -> $invoice_products array
                }else{
                    $purchase->destroy();
                    return response()->json(['message'=>'No se terminó de crear la factura']);
                    }
                } 

                return response()->json(['message'=>'Factura guardada']);
            }
    
            return response()->json(['message'=>'Ocurrió un error al registrar la información']);
            
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
