<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\Sales_item;
use App\Products;
use App\Kardex;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.addSale');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {            
        //invoice headers info
        $sale = new Sales;
        $sale->name = $request->name;
        $sale->quantity = $request->grandquantityvalue;
        $sale->total = $request->grandtotalvalue;
        $sale->is_deleted = 0;

        if ($sale->save()) {
        $id = $sale->id;
        $invoice = ['name' => $sale->name, 'quantity' => $sale->quantity, 'total' => $sale->total, 'date' => $sale->created_at];
        $invoice_products = array();
        $counter = $request->trCount;
        for ($i=1; $i <= $counter; $i++) { 
            $saleitem = new Sales_item;
            //database and request handlers
            $data = ['pnamevalue', 'pcodevalue', 'quantityvalue', 'pricevalue', 'totalvalue'];
            $db = ['product_name', 'product_code', 'quantity', 'price', 'total'];
            for ($j=0; $j < 5; $j++) { 
                //Packing item data to -> $saleitem
                $modifier = $data[$j] ."". $i;
                $dbmodifier = $db[$j];
                $saleitem->$dbmodifier = $request->$modifier;
            }
            $saleitem->sale_id = $id;
            if ($saleitem->save()) {
            //Update quantity 
            $product = Products::select('quantity', 'id')->where('code', $saleitem->product_code)->first();
            $product->quantity = $product->quantity - $saleitem->quantity;
            $product->save();
            //Adding to Kardex
            $kardex = new Kardex;
            $kardex->tag = "Ingreso por producto";
            $kardex->tag_code = "IN";
            $kardex->id_product = $product->id;
            $kardex->quantity = $saleitem->quantity;
            $kardex->value = "+" . $saleitem->total;
            $kardex->unit_price = $saleitem->price;
            $kardex->invoice_id = $id;
            $kardex->save();
            //Adding $saleitems to -> $invoice_products array
            array_push($invoice_products, $saleitem);
            }else{
                $sale->destroy();
                return back()->with('mensaje', 'No se terminó de crear la factura');
                }
            }
                return view('product-order.invoice', compact(['invoice', 'invoice_products']));
        }
            return back()->with('mensaje', 'Ocurrió un error al registrar la información');
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
