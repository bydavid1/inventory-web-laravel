<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kardex;
use App\Products;
use App\Images;
use App\Kardex_tag;
use App\Kardex_type;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class KardexController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {
        $query = Products::select('id','code','name')
        ->with(['first_image'])
        ->where('products.is_deleted', '0');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
                    <a type="button" class="btn btn-info" href="{{ route("records", "$id") }}"><i class="bx bx-task" style="color: white"></i>Ver registros</a>
                    </div>')
        ->addColumn('photo', function($products){
                    $path = asset($products->first_image->src);
                    return '<img class="img-round" src="'.$path.'"  style="max-height:50px; max-width:70px;"/>';
        })
        ->rawColumns(['actions', 'photo'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        return view('pages.kardex', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function records($id)
    {
        $product = Products::select(['id', 'name', 'code', 'description'])->with(['first_image'])->where('id', $id)->first();

        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Kardex"],["name" => $product->name]
        ];

        return view('pages.kardex.records', compact(['id', 'breadcrumbs', 'product']));
    }

    public function getRecords($id)
    {
        $kardex = Kardex::where('product_id', $id);

        return datatables()->eloquent($kardex)
            ->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('d/m/Y');
            })
            ->addColumn('tag', function ($records){
                $tag = Kardex_type::where('id', $records->type_id)->first();
                return $tag->tag . ' <a href="#">' . $records->invoice_ref . '</a>';
            })
            ->addColumn('e_quantity', function ($records) {
                return $records->type_id == 2 ?  : $records->quantity;
            })
            ->addColumn('e_price', function ($records) {
                return $records->type_id == 2 ? '' : '$'. $records->unit_price;
            })
            ->addColumn('e_value', function ($records) {
                return $records->type_id == 2 ? '' : '$'. $records->value;
            })
            ->addColumn('s_quantity', function ($records) {
                return $records->type_id == 2 ? $records->quantity : '';
            })
            ->addColumn('s_price', function ($records) {
                return $records->type_id == 2 ? '$'. $records->unit_price : '';
            })
            ->addColumn('s_value', function ($records) {
                return $records->type_id == 2 ? '$'. $records->value : '';
            })
            ->rawColumns(['tag'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
