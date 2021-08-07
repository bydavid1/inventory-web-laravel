<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use App\Models\Kardex;
use App\Http\Requests\StoreSale;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Traits\Helpers;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    use Helpers;


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Sale::latest()->get();

            return DataTables::of($query)
            ->addColumn('actions', '<div class="float-center">
                <a href="#" role="button"  data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer">
                    <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"></i>
                </a>
                <a href="#" onclick="showInvoice({{"$id"}})"><i class="badge-circle badge-circle-info bx bxs-file-pdf font-medium-1"></i></a>
                </div>')
            ->addColumn('name', function($sale){

                if ($sale->customer_id == null) {
                    return $sale->unregistered_customer;
                } else{
                    return $sale->customer->name;
                }
            })
            ->editColumn('invoice_type', function($sale){
                if($sale->invoice->invoice_type == 'FCF'){
                    return '<span class="badge badge-success">Factura</span>';
                }else if($sale->invoice->invoice_type == 'CF'){
                    return '<span class="badge badge-danger">Credito fiscal</span>';
                }else {
                    return '<span class="badge badge-warnign">Desconocido</span>';
                }
            })
            ->editColumn('subtotal', function($query){
                return '$' . $query->subtotal;
            })
            ->editColumn('total', function($query){
                return '$' . $query->total;
            })
            ->rawColumns(['actions', 'is_available'])
            ->make();
        }
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
        $pageConfigs = [
            'pageHeader' => false,
            'theme' => 'light',
            'extendApp' => true,
            'footerType' => 'hidden',
            'navbarType' => 'static'
        ];
        return view('pages.sales.addSale', compact(['pageConfigs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSale $request)
    {
        try {
            if ($request->validated()) {
                //payment info
                $payment = Payment::create(['payment_method' => $request->paymentMethod, 'total' => $request->totalValue, 'payed_with' => $request->totalValue,
                'returned' => 0.00]);

                //invoice headers info
                $sale = new Sale();
                $sale->payment_id = $payment->id;
                $sale->invoice_type = $request->invoiceType;
                $sale->user_id = $request->user()->id;
                if ($request->customerId == "") {
                    $sale->unregistered_customer = $request->customerName;
                }else{
                    $sale->customer_id = $request->customerId;
                }
                $sale->additional_discounts = $request->discountsValue;
                $sale->additional_payments = $request->additionalPayments;
                $sale->total_quantity = $request->quantityValue;
                $sale->subtotal = $request->subtotalValue;
                $sale->total_discounts = $request->discountsValue; //we will need add discounts option for each product
                $sale->total_tax = "0.00"; //Temporal data
                $sale->total = $request->totalValue;

                //getting last invoice num

                $lastnum = Sale::latest()->first();
                if ($lastnum) {
                    $sale->invoice_num = str_pad($lastnum->invoice_num + 1, 10, '0', STR_PAD_LEFT);
                }else{
                    $sale->invoice_num = str_pad('1', 10, '0', STR_PAD_LEFT); //first invoice
                }

                if ($sale->save()) {

                    $id = $sale->id;
                    $product_list = array();

                    foreach ($request->products as $product) {
                        $saleitem = new SaleItem();
                        $saleitem->sale_id = $id;
                        $saleitem->product_id = $product['id'];
                        $saleitem->quantity = $product['quantity'];
                        $saleitem->unit_price = $product['price'];
                        $saleitem->unit_tax = $product['tax'];
                        $saleitem->total = $product['total'];

                        if ($saleitem->save()) {
                            //Update quantity
                            $product = Product::find($saleitem->product_id);
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

                                    //getting las kardex record

                                    $last_record = Kardex::where('product_id', $saleitem->product_id)->latest()->first();

                                    //Adding to Kardex
                                    $kardex = new Kardex;
                                    $kardex->type_id = 2; //venta en factura
                                    $kardex->product_id = $saleitem->product_id;
                                    $kardex->invoice_ref = $sale->invoice_num;
                                    $kardex->quantity = $saleitem->quantity;
                                    $kardex->unit_price = $saleitem->unit_price;
                                    $kardex->value = $saleitem->total;
                                    $kardex->final_unit_value = $last_record->final_unit_value;
                                    $kardex->final_stock = $product->stock;
                                    $kardex->final_value = $last_record->final_unit_value * $product->stock;

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

                    $files_path = $request->invoiceType == 1 ? "storage/invoices/" : "storage/invoices/credit_invoices/";
                    $invoice = $this->designInvoice($product_list, $request->customerName, $sale, $files_path);

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
     * Check invoice exist
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id = null)
    {
        try {
            $num = str_pad($id, 10, '0', STR_PAD_LEFT);
            $path = public_path() . "/storage/invoices/" .$num . ".pdf";
            if ($id != null) {
                if (file_exists($path)) {
                    //return redirect()->route('showInvoice', ["path" => $path]);
                    return response()->json(["path" => $path], 200);
                }else{
                    return response()->json(["message" => "No se encontró la factura 😕"], 404);
                }
            } else {
                return response()->json(["message" => "Parametro vacío"], 400);
            }
        } catch (Exception $th) {
            return response()->json(["message" => "Ocurrió un errror al tratar de obtener la factura 😕"], 500);
        }
    }

        /**
     * Display the specified resource.
     *
     */
    public function showInvoice($id)
    {
        try {
            $num = str_pad($id, 10, '0', STR_PAD_LEFT);
            $path = public_path() . "/storage/invoices/" .$num . ".pdf";
            return response()->file($path);
        } catch (Exception $th) {
            return response()->json(["message" => "Ocurrió un errror al tratar de obtener la factura 😕"], 500);
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
