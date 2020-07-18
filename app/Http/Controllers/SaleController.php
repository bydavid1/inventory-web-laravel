<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Sales;
use App\Sales_items;
use App\Products;
use App\Payments;
use App\Simple_invoice;
use App\Kardex;
use App\Costumers;
use App\Traits\Helpers;

class SaleController extends Controller
{
    use Helpers;


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        $query = Sales::select('id', 'created_at', 'costumer_id', 'invoice_type', 'unregistered_costumer', 'total_quantity', 'subtotal', 'total');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
        <button type="button" class="btn btn-info" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fas fa-eye" style="color: white"></i></button>
        <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fas fa-trash" style="color: white"></i></button>
        <a type="button" class="btn btn-danger" href="{{ route("invoice", "$id") }}"><i class="fas fa-file-pdf" style="color: white"></i></a>
        </div>')
        ->addColumn('name', function($query){

            if ($query->costumer_id == null) {
                return $query->unregistered_costumer;
            } else{
                $costumer = Costumers::select('name')->where('id', $query->costumer_id)->get();
                return $costumer[0]->name;
            }
        })
        ->editColumn('invoice_type', function($query){
            if($query->invoice_type == '1'){
                return '<span class="badge badge-success">Factura</span>';
            }else{
                return '<span class="badge badge-danger">Credito fiscal</span>';
            }
        })
        ->editColumn('subtotal', function($query){
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
        try {

            //payment info
            $payment = Payments::create(['payment_method' => '1', 'total' => $request->grandtotalvalue, 'payed_with' => $request->grandtotalvalue,
            'returned' => 0.00, 'description' => 'N/A']);

            //invoice headers info
            $sale = new Sales;
            $sale->payment_id = $payment->id;
            $sale->invoice_type = "1";
            $sale->user_id = $request->user()->id;
            $sale->unregistered_customer = $request->name;
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
    
    
                Simple_invoice::create(['sale_id' => $sale->id]);
    
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
