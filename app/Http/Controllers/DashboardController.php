<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use App\Customers;
use App\Products;
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
            $data = array();
            for ($i=1; $i <= 7; $i++) {
               $date = date("Y-m-d", strtotime("-" . $i . " day"));
               $curren_date = ["date" => $date, 'quantity' => $i];
               array_push($data, $curren_date);
            }

            return response()->json(['data' => $data,], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
