<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use App\Kardex;

/**
 * 
 */
trait KardexTrait
{
    
    public function storedata($status, $productid, $quantity, $price, $total, $invoiceid){
        if ($status == "new") {

            for ($i=1; $i < 3; $i++) { 
                $kardex = new Kardex;
                $kardex->tag = "Ingreso al inventario";
                $kardex->tag_code = "MK";
                $kardex->id_product = $productid;
                $kardex->quantity =  $quantity;
                $kardex->value = $total;
                $kardex->unit_price = $price;
                $kardex->invoice_id = $invoiceid;
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
                $kardex->value = $total;
                $kardex->unit_price = $price;
                $kardex->invoice_id = $invoiceid;
                $kardex->save();
        }
    }
}
