<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use App\Kardex;
use App\Jobs\CreateInvoice;
use App\Payments_dates;
use App\Credits;
use App\Products;
use App\Sales_items;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

/**
 *
 */
trait Helpers
{

    protected $items = array();

    public function storedata($status, $productid, $quantity, $price, $total){
        if ($status == "new") {

            for ($i=1; $i < 3; $i++) {
                $kardex = new Kardex;
                $kardex->tag = "Ingreso al inventario";
                $kardex->tag_code = "MK";
                $kardex->id_product = $productid;
                $kardex->quantity =  $quantity;
                $kardex->value_diff = "$ -". $total;
                $kardex->unit_price = $price;
                $kardex->total = $total;
                $kardex->save();

                $kardex->tag = "Compra de producto";
                $kardex->tag_code = "CN";
            }
        }else if ($status == "add") {

                $kardex = new Kardex;
                $kardex->tag = "Compra de producto";
                $kardex->tag_code = "CN";
                $kardex->id_product = $productid;
                $kardex->quantity =  $quantity;
                $kardex->value_diff = "$ -". $total;
                $kardex->unit_price = $price;
                $kardex->total = $total;
                $kardex->save();
        }
    }

    public function designInvoice($products, $name = null, $object, $path){
        $view = \View::make('pages.pdf.invoice', compact('object', 'products', 'name'))->render();
        CreateInvoice::dispatch($view, $path, $object->id);
        return $view;
    }

    public function createCredit($numfees, $startdate, $rangefees, $interestper, $total, $id){

        $credit = new Credits;
        $credit->tax_bill_id = $id;
        $credit->num_fees = $numfees;
        $credit->price_per_fee = $total / $numfees;
        $credit->interest_percentage = $interestper;
        $credit->save();
        $diff = "";

        switch ($rangefees) {
            case '1D':
                $diff = "+1 days";
                break;
            case '10D':
                $diff = "+10 days";
                break;
            case '15D':
                $diff = "+15 days";
                break;
            case '1M':
                $diff = "+1 month";
                break;
            case '2M':
                $diff = "+2 month";
                break;
            case '6M':
                $diff = "+6 month";
                break;
            default:
                $diff = "+15 days";
                break;
        }

        for ($i=1; $i <= $numfees; $i++) {

            $paymentdate = new Payments_dates;
            if ($i == 1) {
                $paymentdate->date = $startdate;
            }else{
                $startdate = date('Y-m-j',strtotime($startdate."".$diff)) ;
                $paymentdate->date = $startdate;
            }

            $paymentdate->credit_id = $credit->id;
            $paymentdate->status = "Pendiente";
            $paymentdate->save();
        }
    }

    public function validateItems($request){
        $count = count($request->products);
        if ($count < 1) {
            throw new Exception("Debe haber al menos un item", 1);
        }

        if ($request->customerName == "") {
            throw new Exception("Nombre requerido", 1);
        }

        if ($request->customerName == "" && $request->customerId == "") {
            throw new Exception("No hay un cliente definido", 1);
        }

        //$all_rules = array();

        foreach ($request->products as $product) {
            $requiredQuantity = $product['quantity'];
            $currentId = $product['id'];
            $currentItem = Products::select('stock', 'name')->where('id', $currentId)->first();
            if ($requiredQuantity > $currentItem->stock) {
                throw new Exception("Solo hay ". $currentItem->stock ." ". $currentItem->name ." y se requiren ". $requiredQuantity , 1);
            }
        }

        $rules = array(
            "products.*.id" => ["required", "numeric"],
            "products.*.quantity" => ["required", "numeric"],
            "products.*.tax" => ["required", "numeric"],
            "products.*.price" => ["required", "numeric","min:0","max:999999"],
            "products.*.total" => ["required", "numeric","min:0","max:999999"]
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            throw new Exception("Data incorrect: " . $validator->getMessageBag(), 1);
        }


        return true;
    }
}
