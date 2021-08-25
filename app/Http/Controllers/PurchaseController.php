<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchase;
<<<<<<< HEAD
use App\Models\Categories;
use App\Models\Images;
use App\Models\Kardex;
use App\Models\Prices;
use App\Models\Products;
use App\Models\Purchase_prices;
use App\Models\Suppliers;
use App\Models\Purchases;
use App\Models\Purchases_items;
use App\Traits\Helpers;
=======
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
>>>>>>> database
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PurchaseController extends Controller
{

<<<<<<< HEAD
    use Helpers;

=======
>>>>>>> database
    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function getRecords()
    {
        $query = Purchases::select(['id', 'created_at', 'supplier_id', 'total_quantity', 'subtotal', 'total']);

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div>
                    <a role="button" data-id="{{"$id"}}">
                        <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"></i>
                    </a>
                    <a href="{{ route("invoiceExist", "$id") }}">
                        <i class="badge-circle badge-circle-info bx bx-arrow-to-right font-medium-1"></i>
                    </a>
                </div>')
        ->addColumn('name', function($query){
                $name = Suppliers::select('name')->where('id', $query->supplier_id)->get();
                return $name[0]->name;
        })
        ->editColumn('sub_total', function($query){
            return '$' . $query->subtotal;
        })
        ->editColumn('total', function($query){
            return '$' . $query->total;
        })
        ->rawColumns(['actions'])
        ->toJson();
=======
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
>>>>>>> database
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
=======
            ["link" => "/", "name" => "Home"],
            ["name" => "Compras"]
>>>>>>> database
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

<<<<<<< HEAD
        $categories = Categories::select(['id', 'name'])->where('is_available', 1)->get();
        $suppliers = Suppliers::select(['id', 'name'])->where('is_available', 1)->get();
=======
        $categories = Category::select(['id', 'name'])->where('is_available', 1)->get();
        $suppliers = Supplier::select(['id', 'name'])->where('is_available', 1)->get();
>>>>>>> database
        //->where('is_available', 1);
        return view('pages.purchases.addPurchase', compact(['categories', 'suppliers', 'pageConfigs']));
    }

    /**
<<<<<<< HEAD
     * Get product List
     *
     * @return \Illuminate\Http\Response
     */
    public function GetList()
    {
        $list = Products::select(['id', 'name', 'quantity', 'purchase', 'price1'])->get();

        return Datatables::of($list)
            ->addColumn('action', '<div style="display: inline-flex">
            <button class="btn btn-primary btn-sm mr-1" onclick="add({{ $id }})"><i class="fas fa-plus"></i>Agregar</button>
            </div>')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
=======
>>>>>>> database
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchase $request)
    {
        try {
<<<<<<< HEAD
            $validated = $request->validated();

            if ($validated) {
                            //invoice headers info
            $purchase = new Purchases;
            $purchase->supplier_id = $request->supplierId;
            $purchase->total_quantity = $request->quantityValue;
            $purchase->total = $request->totalValue;
            $purchase->subtotal = $request->subtotalValue;
            $purchase->discounts = $request->discountsValue;
            $purchase->user_id = $request->user()->id;

            $lastnum = Purchases::latest()->first();
            if ($lastnum) {
                $purchase->invoice_num = str_pad($lastnum->invoice_num + 1, 10, '0', STR_PAD_LEFT);
            }else{
                $purchase->invoice_num = str_pad('1', 10, '0', STR_PAD_LEFT); //first invoice
            }

            if ($purchase->save()) {

                $id = $purchase->id;

                foreach ($request->products as $product) {
                    $purchaseitem = new Purchases_items();

                    $purchaseitem->purchase_id = $id;
                    $purchaseitem->is_new = $product['isNewProduct'];
                    $purchaseitem->quantity = $product['quantity'];
                    $purchaseitem->unit_price = $product['purchase'];
                    $purchaseitem->discount = $product['discount'];
                    $purchaseitem->total = $product['total'];

                    if ($product['isNewProduct'] == true) {

                        //creating new product

                        $newProduct = new Products;
                        $newProduct->code = $product['code'];
                        $newProduct->name = $product['name'];
                        $newProduct->supplier_id = $request->supplierId;
                        $newProduct->category_id = $product['category'];
                        $newProduct->manufacturer_id = '1'; ///<----------Fix this
                        $newProduct->low_stock_alert = '1'; ///<----------Fix this
                        $newProduct->stock = $product['quantity'];
                        $newProduct->type = 1;
                        $newProduct->is_available = 1;
                        $newProduct->is_deleted = 0;
                        $newProduct->save();

                        $prices = new Prices();
                        $prices->product_id = $newProduct->id;
                        $prices->price = $product['price'];
                        $prices->utility = $product['price'] - $product['purchase'];
                        $prices->tax_id = 1;
                        $prices->price_incl_tax = $product['price'];
                        $prices->save();

                        $images = new Images();
                        $images->src = "default.png";
                        $images->product_id = $newProduct->id;
                        $images->type = 'principal';
                        $images->save();

                        $purchase = new Purchase_prices();
                        $purchase->product_id = $newProduct->id;
                        $purchase->value = $product['purchase'];
                        $purchase->save();

                        $kardex = new Kardex();
                        $kardex->type_id = 1; //ingreso a inventario
                        $kardex->product_id = $newProduct->id;
                        $kardex->invoice_ref = $purchase->invoice_num;
                        $kardex->quantity =  $newProduct->stock;
                        $kardex->unit_price = $product['purchase'];
                        $kardex->value = $purchaseitem->total;
                        $kardex->final_unit_value = $product['purchase'];
                        $kardex->final_stock = $newProduct->stock;
                        $kardex->final_value = $purchaseitem->total;
                        $kardex->save();

                        $purchaseitem->product_id = $newProduct->id;
                    } else {

                        $purchaseitem->product_id = $product['id'];
                        //Update quantity
                        $product = Products::find($purchaseitem->product_id);
                        // Make sure we've got the Products model
                        if ($product) {
                            $product->stock = ($product->stock + $purchaseitem->quantity);
                            $product->save();

                            //getting last final_value
                            $last_record = Kardex::where('product_id', $purchaseitem->product_id)->latest()->first();
                            $final_value = ($last_record->final_value + ($purchaseitem->quantity * $purchaseitem->unit_price)) / $product->stock;

                            $kardex = new Kardex();
                            $kardex->type_id = 3; //compra en factura
                            $kardex->product_id = $purchaseitem->product_id;
                            $kardex->invoice_ref = $purchase->invoice_num;
                            $kardex->quantity =  $purchaseitem->quantity;
                            $kardex->unit_price = $purchaseitem->unit_price;
                            $kardex->value = $purchaseitem->total;
                            $kardex->final_unit_value = $final_value;
                            $kardex->final_stock = $product->stock;
                            $kardex->final_value = $kardex->final_unit_value * $product->stock;
                            $kardex->save();
                        }
                    }

                    $purchaseitem->save();
                }


                return response()->json(['message' => 'Factura guardada']);

            }

            return response()->json(['message' => 'Ocurrió un error al registrar la información']);
=======
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
>>>>>>> database

            }
        } catch (Exception $e) {

            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);

        }
    }
<<<<<<< HEAD

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
=======
>>>>>>> database
}
