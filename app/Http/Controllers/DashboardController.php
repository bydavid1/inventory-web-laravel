<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use App\Models\Customers;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\Sales;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getTilesData(){
        try {
            $products = Products::where('is_available', '1')->count();
            $customers = Customers::count();
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
               $salesCount = Sales::whereDate('created_at', $date)->count();
               $purchasesCount = Purchases::whereDate('created_at', $date)->count();
               array_push($dates, $date);
               array_push($sales, $salesCount);
               array_push($purchases, $purchasesCount);
            }

            return response()->json(['labels' => $dates, 'sales' => $sales, 'purchases' => $purchases], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
