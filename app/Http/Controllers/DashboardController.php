<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use Exception;

class DashboardController extends Controller
{
    public function getTilesData(){
        try {
            $products = Product::where('is_available', '1')->count();
            $customers = Customer::count();
            return response()->json(['products' => $products, 'customers' => $customers], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function getSalesChart(){
        try {
            $dates = array();
            $sales = array();
            $purchases = array();
            for ($i=7; $i >= 1; $i--) {
               $date = date("Y-m-d", strtotime("-" . $i . " day"));
               $salesCount = Sale::whereDate('created_at', $date)->count();
               $purchasesCount = Purchase::whereDate('created_at', $date)->count();
               array_push($dates, $date);
               array_push($sales, $salesCount);
               array_push($purchases, $purchasesCount);
            }

            return response()->json(['labels' => $dates, 'sales' => $sales, 'purchases' => $purchases], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getLastItems() {
        try {
            $items = SaleItem::select('unit_price', 'quantity','product_id')->with(['product:id,name'])->take(5)->latest()->get();

            return response()->json(['items' => $items], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
