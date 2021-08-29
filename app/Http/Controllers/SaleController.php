<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use App\Http\Requests\StoreSale;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Sale::with(['invoice'])->latest();

            return DataTables::of($query)
            ->addColumn('actions', '
                        <div class="float-right">
                            <a href="#"
                                role="button"
                                data-toggle="modal"
                                id="destroyCostumerModalBtn"
                                data-destroy-id="{{"$id"}}"
                                data-target="#removeCostumer">
                                <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"></i>
                            </a>
                            <a href="#"
                                onclick="showInvoice({{"$id"}})">
                                <i class="badge-circle badge-circle-info bx bx-link-external font-medium-1"></i>
                            </a>
                        </div>')
            ->addColumn('name', function($sale){

                if ($sale->customer_id == null) {
                    return $sale->unregistered_customer;
                } else{
                    return $sale->customer->name;
                }
            })
            ->addColumn('invoice_type', function($sale){
                if ($sale->invoice) {
                    if($sale->invoice->invoice_type == '1'){
                        return '<span class="badge badge-success">Factura</span>';
                    }else if($sale->invoice->invoice_type == '2'){
                        return '<span class="badge badge-warning">Credito fiscal</span>';
                    }
                } else {
                    return '<span class="badge badge-danger">Desconocido</span>';
                }
            })
            ->addColumn('invoice_num', function($sale) {
                if ($sale->invoice) {
                    return $sale->invoice->invoice_num;
                } else {
                    return '';
                }
            })
            ->editColumn('subtotal', function($query){
                return '$' . $query->subtotal;
            })
            ->editColumn('total', function($query){
                return '$' . $query->total;
            })
            ->editColumn('created_at', function($customer) {
                return Carbon::parse($customer->created_at)->format("d-m-Y");
            })
            ->rawColumns(['actions', 'invoice_type'])
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
            ["link" => "/home", "name" => "Home"],
            ["link" => "#", "name" => "POS"],
            ["name" => "Ventas"]
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
                //payment info, some data is temporally
                $payment = new Payment();
                $payment->method = $request->paymentMethod;
                $payment->total = $request->totalValue;
                $payment->payed_with = $request->totalValue;
                $payment->returned = 0.00;
                $payment->save();

                //invoice headers info
                $sale = new Sale();
                $sale->pos_id = 1; //temporally default
                $sale->additional_discounts = $request->discountsValue;
                $sale->additional_payments = $request->additionalPayments;
                $sale->total_quantity = $request->quantityValue;
                $sale->subtotal = $request->subtotalValue;
                $sale->total_discounts = $request->discountsValue; //we will need add discounts option for each product
                $sale->total_tax = "0.00"; //Temporal data
                $sale->total = $request->totalValue;
                $sale->user_id = $request->user()->id;
                if ($request->customerId == "") {
                    $sale->unregistered_customer = $request->customerName;
                }else{
                    $customer = Customer::find($request->customerId);
                    if ($customer) {
                        $sale->customer()->associate($customer);
                    } else {
                        $payment->delete();
                        throw new Exception("Customer doesn't exist");
                    }
                }

                $sale->payment()->associate($payment);
                $sale->save();

                //getting last invoice num
                $invoiceNumber = Invoice::getLastInvoiceNumber($request->invoiceType);

                //generating prefix for filename
                $prefix = $request->invoiceType == 1 ? "consumidor_final_" : "credito_fiscal_";

                //Creating new Invoice
                $invoice = new Invoice();
                $invoice->invoice_num = $invoiceNumber;
                $invoice->invoice_type = $request->invoiceType;
                $invoice->filename = $prefix . $invoiceNumber;

                $sale->invoice()->save($invoice);

                //Creating items
                $items = array();

                foreach ($request->products as $product) {
                   $saleItem = new SaleItem([
                       "product_id" => $product['id'],
                       "quantity" => $product['quantity'],
                       "unit_price" => $product['price'],
                       "unit_tax" => $product['tax'],
                       "discount" => 0.00, //temp default
                       "total" => $product['total'],
                   ]);

                   Product::updateStock($product['id'], $product['quantity']);

                    // //getting las kardex record

                    // $last_record = Kardex::where('product_id', $saleitem->product_id)->latest()->first();

                    // //Adding to Kardex
                    // $kardex = new Kardex;
                    // $kardex->type_id = 2; //venta en factura
                    // $kardex->product_id = $saleitem->product_id;
                    // $kardex->invoice_ref = $sale->invoice_num;
                    // $kardex->quantity = $saleitem->quantity;
                    // $kardex->unit_price = $saleitem->unit_price;
                    // $kardex->value = $saleitem->total;
                    // $kardex->final_unit_value = $last_record->final_unit_value;
                    // $kardex->final_stock = $product->stock;
                    // $kardex->final_value = $last_record->final_unit_value * $product->stock;

                   array_push($items, $saleItem);

                   //Generating kardex report
                   $report = KardexReport::getOpenedReport($product['id']);

                   if ($report) {
                        $kardexItem = new KardexItem();
                        $kardexItem->invoice_id = $invoice->id;
                        $kardexItem->product_id = $product['id'];
                        $kardexItem->quantity = $product['quantity'];
                        $kardexItem->unit_value = $product['price'];
                        $kardexItem->value = $product['total'];
                        $kardexItem->final_stock = $product['quantity']; //CAMBIARLO POR CURRENT STOCK
                        $kardexItem->final_unit_value = $report->lastItem->final_unit_value;
                        $kardexItem->final_value = $report->lastItem->final_unit_value * $product['quantity'];
                        $report->records()->save($kardexItem);
                   }
                }

                $sale->items()->saveMany($items);

                if ($sale->save()) {

                    $invoice = Invoice::invoiceToPDF($items, $sale, $request->customerName, $invoice->filename);

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
    public function showInvoice($id)
    {
        try {
            $sale = Sale::find($id);
            $path = public_path() . "/storage/invoices/" . $sale->invoice->filename . ".pdf";
            if (file_exists($path)) {
                return response()->file($path);
            }else{
                return response()->json(["message" => "No se encontró la factura 😕"], 404);
            }
        } catch (Exception $th) {
            return response()->json(["message" => "" + $th->getMessage()], 500);
        }
    }
}
