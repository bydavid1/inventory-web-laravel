<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\Sales_item;

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
    public function store(Request $request)
    {
       $sale = new Sales;
       $sale->name = $request->name;
       $sale->quantity = $request->grandquantityvalue;
       $sale->total = $request->grandtotalvalue;
       $sale->is_deleted = 0;

       if ($sale->save()) {
        $id = $sale->id;
        
        $counter = $request->trCount;
        for ($i=1; $i <= $counter; $i++) { 
            $saleitem = new Sales_item;
            $data = ['pnamevalue', 'pcodevalue', 'quantityvalue', 'pricevalue', 'totalvalue'];
            $db = ['product_name', 'product_code', 'quantity', 'price', 'total'];
            for ($j=0; $j < 5; $j++) { 
             $modifier = $data[$j] ."". $i;
             $dbmodifier = $db[$j];
             $saleitem->$dbmodifier = $request->$modifier;
            }
            $saleitem->sale_id = $id;
            $saleitem->save();
        }

        return back()->with("mensaje", "Factura hecha");
       }
       return back()->with("mensaje", "Error");
    }

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
}
