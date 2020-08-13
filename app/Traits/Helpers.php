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
        $view = \View::make('pdf.invoice', compact('object', 'products', 'name'))->render();
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
        $counter = $request->itemsCount;

        if ($counter < 1) {
            throw new Exception("Debe haber al menos un item", 1);
        }

        if ($request->name == "") {
            throw new Exception("Nombre requerido", 1);
        }

        $all_rules = array();

        for ($i=1; $i <= $counter ; $i++) {
            //validation rules 
            $rules = array(
                "productId". $i => ["required", "numeric"],
                "quantityValue". $i => ["required", "numeric"],
                "priceValue". $i => ["required", "numeric","min:0","max:9999999"],
                "totalValue". $i => ["required", "numeric","min:0","max:9999999"]
            );

            //stock validation
            $requiredQuantity = $request->{"quantityValue" . $i};
            $currentId = $request->{"productId" . $i};
            $currentItem = Products::select('stock', 'name')->where('id', $currentId)->first();
            if ($requiredQuantity > $currentItem->stock) {
                throw new Exception("Solo hay ". $currentItem->stock ." ". $currentItem->name ." y se requiren ". $requiredQuantity , 1);
            }

            array_push($all_rules, $rules);

        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            {
                throw new Exception("Error Processing Request: " . $validator->getMessageBag(), 1);              
            }

        return true;
    }
}
