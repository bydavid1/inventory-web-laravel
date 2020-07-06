<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Sales;
use App\Sales_items;
use App\Products;
use App\Invoices;
use App\Payments;
use App\Credit_invoice;
use App\Kardex;
use App\Traits\Helpers;

class SaleController extends Controller
{
    use Helpers;

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
    public function save(Request $request)
    {            
        try {
        //invoice headers info
        $sale = new Sales;
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

        for ($i=1; $i <= $counter; $i++) { 
            $saleitem = new Sales_items;
            //database and request handlers
            $data = ['idvalue', 'quantityvalue', 'pricevalue', 'totalvalue'];
            $db = ['product_id', 'quantity', 'unit_price', 'total'];
            for ($j=0; $j < 4; $j++) { 
                //Packing item data to -> $saleitem
                $modifier = $data[$j] ."". $i;
                $dbmodifier = $db[$j];
                $saleitem->$dbmodifier = $request->$modifier;
            }//for $j

            //Add Sale ID
            $saleitem->sale_id = $id;

            if ($saleitem->save()) {
                
            //Update quantity 
            $product = Products::find($saleitem->product_id);
            // Make sure we've got the Products model
            if($product) {
                $product->quantity = ($product->quantity - $saleitem->quantity);
                $product->save();
            }

            //Adding to Kardex
            $kardex = new Kardex;
            $kardex->tag = "Venta de producto";
            $kardex->id_product = $saleitem->product_id;
            $kardex->quantity = $saleitem->quantity;
            $kardex->value_diff = "+ $" . $saleitem->total;
            $kardex->unit_price = $saleitem->unit_price;
            $kardex->total = $saleitem->total;
            $kardex->save();

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

                $sale->destroy();
                return response()->json(['message'=>'No se terminó de crear la factura'], 500);
                }

            } //for $i

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
    public function invoice($id)
    {
        try {
            
            $path = public_path() . "\invoices\\$id.pdf"; 
            if (file_exists($path)) {
                return response()->file($path);
            }else{
                return redirect()->back()->with('alert', 'La factura no esta guardada');
            }
        } catch (Exception $th) {
            //throw $th;
        }
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
