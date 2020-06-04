<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Sales;
use App\Sales_item;
use App\Products;
use App\Kardex;
use PDF;

class SaleController extends Controller
{
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
        $sale->costumer = $request->name;
        $sale->quantity = $request->grandquantityvalue;
        $sale->subtotal = $request->grandtotalvalue;
        $sale->total = $request->grandtotalvalue;
        $sale->is_deleted = 0;

        if ($sale->save()) {
        $id = $sale->id;
        $invoice_products = "";
        $counter = $request->trCount;
        for ($i=1; $i <= $counter; $i++) { 
            $saleitem = new Sales_item;
            //database and request handlers
            $data = ['id', 'quantityvalue', 'pricevalue', 'totalvalue'];
            $db = ['product_id', 'quantity', 'unit_price', 'total'];
            for ($j=0; $j < 5; $j++) { 
                //Packing item data to -> $saleitem
                $modifier = $data[$j] ."". $i;
                $dbmodifier = $db[$j];
                $saleitem->$dbmodifier = $request->$modifier;
            }
            //Add Sale ID
            $saleitem->sale_id = $id;

            if ($saleitem->save()) {
            //Update quantity 
            $product = Products::select('quantity')->where('id', $saleitem->product_id)->first();
            $product->quantity = $product->quantity - $saleitem->quantity;
            $product->save();

            //Adding to Kardex
            $kardex = new Kardex;
            $kardex->tag = "Ingreso por producto";
            $kardex->tag_code = "IN";
            $kardex->id_product = $saleitem->product_id;
            $kardex->quantity = $saleitem->quantity;
            $kardex->value_diff = "+ $" . $saleitem->total;
            $kardex->unit_price = $saleitem->price;
            $kardex->total = $saleitem->total;
            $kardex->save();

            $product_name = $request->product_name . "" . $i;
            $product_code = $request->product_code . "" . $i;

            $invoice_products .= "<tr><td>". $product_code ."</td><td>". $product_name ."</td><td>".$saleitem->quantity."</td><td>".$saleitem->price."</td><td>".$saleitem->total."</td></tr>";
            //Adding $saleitems to -> $invoice_products array
            }else{
                $sale->destroy();
                return response()->json(['message'=>'No se terminó de crear la factura']);
                }
            } 
            //Design invoice
            $invoice = $this->designInvoice($invoice_products, $sale);

            $pdf = PDF::loadHTML($invoice)->save(public_path('invoices/') . $id . '.pdf');
            //send invoice
            return response()->json(['message'=>'Factura guardada', 'data' => compact('invoice')]);
        }

        return response()->json(['message'=>'Ocurrió un error al registrar la información']);
        
        } catch (Exception $e) {

            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);

        }
    }

    function designInvoice($products, $sale){

        $invoice = '<html>
        <head>
            <title>Imprimir</title>
            <link rel="stylesheet" href="'. public_path('css/adminlte.min.css') .'>
            <div class="wrapper" id="print">
                <!-- Main content -->
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h2 class="page-header">
                                <i class="fas fa-globe"></i> AdminLTE, Inc.
                                <small class="float-right">Date: '. $sale->created_at .'</small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Admin, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (804) 123-5432<br>
                                Email: info@almasaeedstudio.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>'. $sale->name .'</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (555) 539-1037<br>
                                Email: john.doe@example.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #007612</b><br>
                            <br>
                            <b>Order ID:</b> 4F3S8J<br>
                            <b>Payment Due:</b> 2/22/2014<br>
                            <b>Account:</b> 968-34567
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Cant</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    '. $products.'
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <p class="lead">Amount Due 2/22/2014</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>'. $sale->total .'</td>
                                    </tr>
                                    <tr>
                                        <th>Tax (9.3%)</th>
                                        <td>$10.34</td>
                                    </tr>
                                    <tr>
                                        <th>Cantidad:</th>
                                        <td>'. $sale->quantity .'</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>'. $sale->total .'</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- ./wrapper -->
            </body>
        </html>';

        return $invoice;
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
