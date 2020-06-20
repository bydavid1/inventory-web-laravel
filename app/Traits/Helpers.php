<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use App\Kardex;
use App\Jobs\CreateInvoice;

/**
 * 
 */
trait Helpers
{
    
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
        $this->dispatch(new CreateInvoice($view, $path, $object->id));
        return $view;
    }

    public function createCredit(){

    }
}
