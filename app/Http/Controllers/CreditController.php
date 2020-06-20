<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


use App\Credits;
use App\Credits_item;
use Illuminate\Http\Request;
use App\Traits\Helpers;
use App\Products;
use App\Kardex;

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
            $credit = new Credits;
            $credit->date = $request->date;
            $credit->costumer_id = $request->costumerid;
            $credit->payment_status = $request->payment;
            $credit->delivery_status = $request->delivery;
            $credit->additional_discounts = $request->discounts;
            $credit->additional_payments = $request->mpayments;
            $credit->comments = $request->comments;
            $credit->quantity = $request->grandquantityvalue;
            $credit->subtotal = $request->subtotalvalue;
            $credit->discounts = $request->discountsvalue;
            $credit->tax = $request->taxesvalue;
            $credit->total = $request->grandtotalvalue;

            if ($credit->save()) {
                
                $product_list = array();
                $lastid = $credit->id;
                $counter = $request->trCount;

                for ($i = 1; $i <= $counter; $i++) {

                    $credititem = new Credits_item;
                    $credititem->credit_id = $lastid;
                    $credititem->unit_tax = 0.00;
                    $credititem->discount = 0.00;

                    //database and request handlers
                    $data = ['idvalue', 'quantityvalue', 'pricevalue', 'totalvalue'];
                    $db = ['product_id', 'quantity', 'unit_price', 'total'];
                    for ($j = 0; $j < 4; $j++) {
                        //Packing item data to -> $saleitem
                        $modifier = $data[$j] . "" . $i;
                        $dbmodifier = $db[$j];
                        $credititem->$dbmodifier = $request->$modifier;
                    } //for $j

                    if ($credititem->save()) {
                        //Update quantity
                        $product = Products::find($credititem->product_id);
                        $product->quantity = ($product->quantity - $credititem->quantity);
                        $product->save();

                        //Adding to Kardex
                        $kardex = new Kardex;
                        $kardex->tag = "Venta de producto";
                        $kardex->tag_code = "VNC";
                        $kardex->id_product = $credititem->product_id;
                        $kardex->quantity = $credititem->quantity;
                        $kardex->value_diff = "+ $" . $credititem->total;
                        $kardex->unit_price = $credititem->unit_price;
                        $kardex->total = $credititem->total;
                        $kardex->save();

                        //Adding $saleitems to -> $invoice_products array
                        $product_items = array(
                            'code' => $request->{'pcodevalue' . $i},
                            'name' => $request->{'pnamevalue' . $i},
                            'quantity' => $credititem->quantity,
                            'price' => $credititem->unit_price,
                            'total' => $credititem->total
                        );

                        array_push($product_list, $product_items);
                        

                    } else {
                        $sale->destroy();
                        return response()->json(['message' => 'No se terminó de crear la factura'], 500);
                    }
                } // for $i
                
                if ($request->payment == 2) {
                    $this->createCredit();
                }
                
                //Design invoice
                $invoice = $this->designInvoice($product_list, $request->costumer, $credit, 'invoices/credit');

                //send invoice
                return response()->json(['message' => 'Factura guardada', 'data' => compact('invoice')]);
            } else {
                return response()->json(['message' => 'Ocurrió un error al registrar la información'], 500);
            }
        } catch (\Exception $e) {
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
