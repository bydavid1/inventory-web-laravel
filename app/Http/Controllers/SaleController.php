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
use Exception;

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
        $query = Sales::select('id', 'created_at', 'costumer_id', 'invoice_type', 'unregistered_customer', 'total_quantity', 'subtotal', 'total');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
        <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fa fa-trash" style="color: white"></i></button>
        <a type="button" class="btn btn-danger" href="{{ route("invoice", "$id") }}"><i class="fa fa-file-pdf-o" style="color: white"></i></a>
        </div>')
        ->addColumn('name', function($query){

            if ($query->costumer_id == null) {
                return $query->unregistered_customer;
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
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        return view('pages.sales', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageConfigs = ['pageHeader' => false, 'theme' => 'semi-dark', 'extendApp' => true, 'footerType' => 'hidden'];

        $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        return view('pages.sales.addSale', compact(['products', 'pageConfigs']));
    }

    /**
     * Sale products pagination with ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(Request $request)
    {
        if($request->ajax()){
            $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
            return view('pages.sales.list_products', compact('products'))->render();
        }
    }

    /**
     * Search products pagination with ajax 
     *
     * @return \Illuminate\Http\Response
     */
    public function search($query = null)
    {
        if ($query != null) {
            $products = Products::select('id','code','name','stock','description')->with(['first_price', 'first_image'])->where("code", "like", "%". $query ."%")->orWhere("name", "like", "%". $query ."%")->paginate(15);
        }else{
            $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        }
            
        return view('pages.sales.list_products', compact('products'))->render();
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
                //payment info
                $payment = Payments::create(['payment_method' => '1', 'total' => $request->totalValue, 'payed_with' => $request->totalValue,
                'returned' => 0.00, 'description' => 'N/A']);

                //invoice headers info
                $sale = new Sales;
                $sale->payment_id = $payment->id;
                $sale->invoice_type = "1";
                $sale->user_id = $request->user()->id;
                $sale->unregistered_customer = $request->name;
                $sale->additional_discounts = $request->discountsValue;
                $sale->additional_payments = $request->additionalPayments;
                $sale->total_quantity = $request->quantityValue;
                $sale->subtotal = $request->subtotalValue;
                $sale->total_discounts = $request->discountsValue; //we will need add discounts option for each product
                $sale->total_tax = "0.00"; //Temporal data
                $sale->total = $request->totalValue;

                if ($sale->save()) {

                    $id = $sale->id;
                    $product_list = array();

                    foreach ($request->products as $product) {
                        $saleitem = new Sales_items;
                        $saleitem->sale_id = $id;
                        $saleitem->product_id = $product['id'];
                        $saleitem->quantity = $product['quantity'];
                        $saleitem->unit_price = $product['price'];
                        $saleitem->unit_tax = $product['tax'];
                        $saleitem->total = $product['total'];

                        if ($saleitem->save()) {
                            //Update quantity 
                            $product = Products::find($saleitem->product_id);
                            // Make sure we've got the Products model
                            if ($product) {
                                $product->stock = ($product->stock - $saleitem->quantity);

                                if ($product->save()) {
                                    //Adding $saleitems to -> $invoice_products array
                                    $product_items = array(
                                        'code' => $product['code'],
                                        'name' => $product['name'],
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
                                        throw new Exception("Could not save kardex information at product ". $product['name'], 1);  
                                    }
                                }else{
                                    throw new Exception("Could not update stock of product " . $product['name'], 1);  
                                }

                            } else {
                                throw new Exception("Product " . $product['name'] . "not exist", 1);    
                            }

                        } else {
                            $sale->delete();
                            throw new Exception("Corrupt data in item: ". $product['name'], 1);
                        }


                    }

                    Simple_invoice::create(['sale_id' => $sale->id]);

                    //Design invoice
                    $invoice = $this->designInvoice($product_list, $request->name, $sale, "invoices/");

                    //send invoice
                    return response()->json(['message' => 'Factura guardada', 'invoice' => compact('invoice')]);

                }else{
                    throw new Exception("Error guardando la informacion de la venta", 1);
                }

            } else {
                return response()->json(['message' => 'Data was invalid'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
