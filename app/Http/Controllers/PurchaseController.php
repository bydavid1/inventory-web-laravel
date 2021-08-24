<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchase;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PurchaseController extends Controller
{

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Purchase::latest();

            return Datatables::of($query)
            ->addColumn('actions', '
                        <div class="float-right">
                            <a role="button" data-id="{{"$id"}}">
                                <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"></i>
                            </a>
                            <a href="#" onclick="showInvoice({{"$id"}})">
                                <i class="badge-circle badge-circle-info bx bx-arrow-to-right font-medium-1"></i>
                            </a>
                        </div>')
            ->addColumn('name', function($query){
                return $query->supplier->name;
            })
            ->editColumn('created_at', function($query) {
                return Carbon::parse($query->created_at)->format('d-m-Y');
            })
            ->editColumn('subtotal', function($query){
                return '$' . $query->subtotal;
            })
            ->editColumn('total', function($query){
                return '$' . $query->total;
            })
            ->rawColumns(['actions'])
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
            ["link" => "/", "name" => "Home"],
            ["name" => "Compras"]
        ];
        return \view('pages.purchases', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageConfigs = ['pageHeader' => false, 'theme' => 'light', 'extendApp' => true, 'footerType' => 'hidden', 'navbarType' => 'static'];

        $categories = Category::select(['id', 'name'])->where('is_available', 1)->get();
        $suppliers = Supplier::select(['id', 'name'])->where('is_available', 1)->get();
        //->where('is_available', 1);
        return view('pages.purchases.addPurchase', compact(['categories', 'suppliers', 'pageConfigs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchase $request)
    {
        try {
            if ($request->validated()) {
                //invoice headers info
                $purchase = new Purchase();

                $supplier = Supplier::find($request->supplierId);
                if ($supplier) {
                    $purchase->supplier_id = $supplier->id;
                } else {
                    throw new Exception('Supplier does not exist');
                }

                $purchase->user_id = $request->user()->id;
                $purchase->branch_id = 1; //temporally
                $purchase->delivery_status = 1; //temporally
                $purchase->quantity = $request->quantityValue;
                $purchase->total = $request->totalValue;
                $purchase->subtotal = $request->subtotalValue;
                $purchase->discounts = $request->discountsValue;

                if ($purchase->save()) {

                    //Creating invoice
                    $invoiceNumber = Invoice::getLastInvoiceNumber(3); //3 = purchase invoice

                    $invoice = new Invoice();
                    $invoice->invoice_num = $invoiceNumber;
                    $invoice->invoice_type = 3;
                    $invoice->filename = 'compra_' . $invoiceNumber;

                    $purchase->invoice()->save($invoice);

                    $items = array();

                    foreach ($request->products as $product) {

                        $purchaseitem = new PurchaseItem([
                            'is_new' => $product['isNewProduct'],
                            'quantity' => $product['quantity'],
                            'unit_price' => $product['purchase'],
                            'discount' => $product['discount'],
                            'total' => $product['total']
                        ]);

                        /*
                        * If the current pruduct is new (isn't in the inventory)
                        * store in database
                        */

                        if ($product['isNewProduct'] == true) {

                            //creating new product
                            $newProduct = new Product();
                            $newProduct->code = $product['code'];
                            $newProduct->name = $product['name'];
                            $newProduct->category_id = $product['category'];
                            $newProduct->unit_measure_id = 1; //temporally
                            $newProduct->brand_id = '1'; ///<----------Fix this
                            $newProduct->is_service = 2;
                            $newProduct->is_available = 1;
                            $newProduct->save();

                            /**** Saving supplier ****/
                            $newProduct->suppliers()->attach($request->supplierId);

                            /**** Saving stock ****/
                            $newProduct->stock()->attach(1, [
                                'stock' => $product['quantity'],
                                'low_stock' => 2 //temporaly default
                            ]);

                            $price = new Price([
                                'branch_id' => 1,
                                'price' => $product['price'],
                                'price_w_tax' => ($product['price'] * 0.13) + $product['price'],
                                'utility' => $product['price'] - $product['purchase'],
                                'tax_id' => 1
                            ]);

                            //Creating product prices
                            $newProduct->prices()->save($price);

                            //Saving photo path
                            $newProduct->photo()->save(new Photo([
                                'source' => 'default.png'
                            ]));

                            //Setting product_id to purchase item
                            $purchaseitem['product_id'] = $newProduct->id;

                            //Generating kardex report
                            $kardexReport = new KardexReport();
                            $kardexReport->start_date = date('Y-m-d');

                            $newProduct->kardexReport()->save($kardexReport);

                            $kardexItem = new KardexItem();
                            $kardexItem->product_id = $newProduct->id;
                            $kardexItem->is_initial = 1;
                            $kardexItem->quantity =  $product['quantity'];
                            $kardexItem->unit_value = $product['purchase'];
                            $kardexItem->value = $product['purchase'] * $product['quantity'];
                            $kardexItem->final_stock = $product['quantity'];
                            $kardexItem->final_unit_value = $product['purchase'];
                            $kardexItem->final_value = $product['purchase'] * $product['quantity'];

                            $kardexReport->records()->save($kardexItem);

                        } else {
                            //Update quantity
                            $existingProduct = Product::find($product['id']);
                            // Make sure we've got the Products model
                            if ($existingProduct) {
                                Product::updateStock($existingProduct->id, $purchaseitem->quantity, true);
                            }

                            //Check if it's a new supplier
                            foreach ($existingProduct->suppliers as $productSupplier) {
                                if ($productSupplier->id != $supplier->id) {
                                    $existingProduct->suppliers()->attach($supplier->id);
                                }
                            }

                            //Setting product_id to purchase item
                            $purchaseitem['product_id'] = $product['id'];

                            //Generating kardex report
                            $report = KardexReport::getOpenedReport($product['id']);

                            if ($report) {
                                $final_unit_value = ($report->lastItem->final_value + ($product['quantity'] * $product['purchase'])) / $product['quantity'];

                                $kardexItem = new KardexItem();
                                $kardexItem->invoice_id = $invoice->id;
                                $kardexItem->product_id = $product['id'];
                                $kardexItem->quantity = $product['quantity'];
                                $kardexItem->unit_value = $product['purchase'];
                                $kardexItem->value = $product['total'];
                                $kardexItem->final_stock = $product['quantity']; //CAMBIARLO POR CURRENT STOCK
                                $kardexItem->final_unit_value = $final_unit_value;
                                $kardexItem->final_value = $kardexItem->final_unit_value * $product['quantity'];
                                $report->records()->save($kardexItem);
                            }
                        }

                        array_push($items, $purchaseitem);
                    }

                    $purchase->items()->saveMany($items);

                    Invoice::invoiceToPDF($items, $purchase, $supplier->name, $invoice->filename);

                    return response()->json(['message' => 'Factura guardada']);

                }

                return response()->json(['message' => 'Ocurrió un error al registrar la información']);

            }
        } catch (Exception $e) {

            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);

        }
    }
}
