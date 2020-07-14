<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


use Illuminate\Http\Request;
use App\Sales;
use App\Sales_items;
use App\Products;
use App\Payments;
use App\Credit_invoice;
use App\Kardex;
use App\Traits\Helpers;

class CreditController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('credit.addCredit');
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

            $payment = Payments::create(['payment_method' => '1', 'total' => $request->grandtotalvalue, 'payed_with' => $request->grandtotalvalue,
            'returned' => 0.00, 'description' => 'N/A']);

            //invoice headers info
            $sale = new Sales;
            $sale->payment_id = $payment->id;
            $sale->invoice_type = "2";
            $sale->user_id = $request->user()->id;
            $sale->costumer_id = $request->costumer_id;
            $sale->delivery_status = $request->delivery;
            $sale->additional_discounts = $request->grandtotalvalue;
            $sale->additional_payments = $request->mpayments;
            $sale->total_quantity = $request->grandquantityvalue;
            $sale->subtotal = $request->subtotalvalue;
            $sale->total_discounts = $request->discountsvalue;
            $sale->total_tax = $request->taxesvalue;
            $sale->total = $request->grandtotalvalue;
    
            if ($sale->save()) {
    
            $id = $sale->id;
            $product_list = array();
            $counter = $request->trCount;
    
            for ($i=0; $i < $counter; $i++) { 
                $saleitem = new Sales_items;
                $saleitem->sale_id = $id;
                //database and request handlers
                $data = ['idvalue', 'quantityvalue', 'pricevalue', 'amountvalue', 'totalvalue'];
                $db = ['product_id', 'quantity', 'unit_price', 'unit_tax', 'total'];
                for ($j=0; $j < 5; $j++) { 
                    //Packing item data to -> $saleitem
                    $modifier = $data[$j] ."". $i;
                    $dbmodifier = $db[$j];
                    $saleitem->$dbmodifier = $request->$modifier;
                }//for $j
    
                if ($saleitem->save()) {
                    
                    //Adding to Kardex
                    $kardex = new Kardex;
                    $kardex->tag = "Venta de producto";
                    $kardex->product_id = $saleitem->product_id;
                    $kardex->quantity = $saleitem->quantity;
                    $kardex->difference = "+ $" . $saleitem->total;
                    $kardex->unit_price = $saleitem->unit_price;
                    $kardex->total = $saleitem->total;
    
                    $kardex->save();
    
                    //Update quantity 
                    $product = Products::find($saleitem->product_id);
                    // Make sure we've got the Products model
                    if($product) {
                        $product->stock = ($product->stock - $saleitem->quantity);
                        $product->save();
                    }else{
                        //else
                    }
    
                    //Adding $saleitems to -> $invoice_products array
                    $product_items = array(
                        'code' => $request->{'pcodevalue' . $i},
                        'name' => $request->{'pnamevalue' . $i},
                        'quantity' => $saleitem->quantity,
                        'price' => $saleitem->unit_price,
                        'total' => $saleitem->total
                    );
    
                    array_push($product_list, $product_items);
    
                }else{
    
                    $sale->delete();
                    return response()->json(['message'=>'No se terminó de crear la factura'], 500);
                    }
    
                } //for $i
    
    
                Credit_invoice::create(['invoice_id' => $sale->id, 'serial' => 'N/A']);
    
                //Design invoice
                $invoice = $this->designInvoice($product_list, $request->costumer, $sale, "invoices/");
    
                //send invoice
                return response()->json(['message'=>'Factura guardada', 'data' => compact('invoice')]);
            }
    
            return response()->json(['message'=>'Ocurrió un error al registrar la información'], 500);
            
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
