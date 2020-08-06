<?php
namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Sales;
use App\Sales_items;
use App\Products;
use App\Payments;
use App\Simple_invoice;
use App\Kardex;
use App\Costumers;
use App\Traits\Helpers;
use Exception;

class SaleController extends Controller
{
    use Helpers;


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        $query = Sales::select('id', 'created_at', 'costumer_id', 'invoice_type', 'unregistered_customer', 'total_quantity', 'subtotal', 'total');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
        <button type="button" class="btn btn-info" data-toggle="modal" id="editCostumerModalBtn" data-id="{{"$id"}}" data-target="#editCostumer"><i class="fa fa-eye" style="color: white"></i></button>
        <button type="button" class="btn btn-warning" data-toggle="modal" id="destroyCostumerModalBtn" data-destroy-id="{{"$id"}}" data-target="#removeCostumer" ><i class="fa fa-trash" style="color: white"></i></button>
        <a type="button" class="btn btn-danger" href="{{ route("invoice", "$id") }}"><i class="fa fa-file-pdf-o" style="color: white"></i></a>
        </div>')
        ->addColumn('name', function($query){

            if ($query->costumer_id == null) {
                return $query->unregistered_customer;
            } else{
                $costumer = Costumers::select('name')->where('id', $query->costumer_id)->get();
                return $costumer[0]->name;
            }
        })
        ->editColumn('invoice_type', function($query){
            if($query->invoice_type == '1'){
                return '<span class="badge badge-success">Factura</span>';
            }else{
                return '<span class="badge badge-danger">Credito fiscal</span>';
            }
        })
        ->editColumn('subtotal', function($query){
            return '$' . $query->subtotal;
        })
        ->editColumn('total', function($query){
            return '$' . $query->total;
        })
        ->rawColumns(['actions', 'invoice_type'])
        ->toJson();
    }

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
        $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
        return view('sales.addSale', compact(['products']));
    }

    /**
     * Sale products pagination with ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(Request $request)
    {
        if($request->ajax()){
            $products = Products::with(['first_image','first_price'])->where('is_deleted', '0')->where('stock','>','0')->paginate(15);
            return view('sales.list_products', compact('products'))->render();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {            
        try {
            $counter = $request->trCount;
            if ($this->validateItems($counter, $request)) {
                return response()->json(['message'=> 'Si Pasa'], 200);
            }else{
                return response()->json(['message'=> 'No pasaa'], 500);
            }
            
        } catch (Exception $e) {

            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);

        }
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
