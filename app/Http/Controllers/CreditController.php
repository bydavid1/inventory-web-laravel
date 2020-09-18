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
use Exception;

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
        $pageConfigs = ['pageHeader' => false, 'theme' => 'light', 'extendApp' => true, 'footerType' => 'hidden', 'navbarType' => 'static'];
        
        $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        return \view('pages.sales.addCredit', compact(['products', 'pageConfigs']));
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

            if ($this->validateItems($request)) {
                $payment = Payments::create(['payment_method' => '1', 'total' => $request->grandtotalvalue, 'payed_with' => $request->grandtotalvalue,
                'returned' => 0.00, 'description' => 'N/A']);
    
                //invoice headers info
                $sale = new Sales;
                $sale->payment_id = $payment->id;
                $sale->invoice_type = "2";
                $sale->user_id = $request->user()->id;
                $sale->costumer_id = $request->costumerid;
                $sale->delivery_status = $request->delivery;
                $sale->additional_discounts = $request->grandtotalvalue;
                $sale->additional_payments = $request->mpayments;
                $sale->total_quantity = $request->grandquantityvalue;
                $sale->subtotal = $request->subtotalvalue;
                $sale->total_discounts = $request->discountsvalue;
                $sale->total_tax = "0.00"; //Temporal data
                $sale->total = $request->grandtotalvalue;
        
                if ($sale->save()) {

                    $id = $sale->id;
                    $product_list = array();
                    $counter = $request->itemsCount;

                    for ($i = 1; $i <= $counter; $i++) {
                        $saleitem = new Sales_items;
                        $saleitem->sale_id = $id;
                        //database and request handlers
                        $data = ['productId', 'quantityValue', 'priceValue', 'amountValue', 'totalValue'];
                        $db = ['product_id', 'quantity', 'unit_price', 'unit_tax', 'total'];
                        for ($j = 0; $j < 5; $j++) {
                            //Packing item data to -> $saleitem
                            $modifier = $data[$j] . "" . $i;
                            $dbmodifier = $db[$j];
                            $saleitem->$dbmodifier = $request->$modifier;
                        } //for $j

                        if ($saleitem->save()) {
                            //Update quantity 
                            $product = Products::find($saleitem->product_id);
                            // Make sure we've got the Products model
                            if ($product) {
                                $product->stock = ($product->stock - $saleitem->quantity);

                                if ($product->save()) {
                                    //Adding $saleitems to -> $invoice_products array
                                    $product_items = array(
                                        'code' => $product->code,
                                        'name' => $product->name,
                                        'quantity' => $saleitem->quantity,
                                        'price' => $saleitem->unit_price,
                                        'total' => $saleitem->total
                                    );

                                    array_push($product_list, $product_items);

                                    //Adding to Kardex
                                    $kardex = new Kardex;
                                    $kardex->tag = "Venta de producto";
                                    $kardex->product_id = $saleitem->product_id;
                                    $kardex->quantity = $saleitem->quantity;
                                    $kardex->difference = "+ $" . $saleitem->total;
                                    $kardex->unit_price = $saleitem->unit_price;
                                    $kardex->total = $saleitem->total;

                                    if (!$kardex->save()) {
                                        throw new Exception("Could not save kardex information at product ". $i, 1);  
                                    }
                                }else{
                                    throw new Exception("Could not update stock of product " . $i, 1);  
                                }

                            } else {
                                throw new Exception("Product " . $i . "not exist", 1);    
                            }

                        } else {
                            $sale->delete();
                            throw new Exception("Corrupt data in item: ". $i, 1);
                        }
                        
                    } //for $i

                    Credit_invoice::create(['sale_id' => $sale->id, 'serial' => 'N/A']);

                    //Design invoice
                    $invoice = $this->designInvoice($product_list, $request->name, $sale, "invoices/credits/");

                    //send invoice
                    return response()->json(['message' => 'Factura guardada', 'data' => compact('invoice')]);

                }
        
                return response()->json(['message'=>'Ocurrió un error al registrar la información'], 500);
            }
            
            } catch (Exception $e) {
    
                return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
    
            }
    }
}
