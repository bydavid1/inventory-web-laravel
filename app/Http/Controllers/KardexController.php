<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Kardex;
use App\Models\Products;
use App\Models\Images;
use App\Models\Kardex_tag;
use App\Models\Kardex_type;
=======
use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Product;
>>>>>>> database
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
<<<<<<< HEAD
        $query = Products::select('id','code','name')
        ->with(['first_image'])
        ->where('products.is_deleted', '0');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
                    <a type="button" class="btn btn-info" href="{{ route("records", "$id") }}"><i class="bx bx-task" style="color: white"></i>Ver registros</a>
                    </div>')
        ->addColumn('photo', function($products){
                    $path = asset($products->first_image->src);
=======
        $query = Product::select('id','code','name')
        ->with(['photo']);

        return datatables()->eloquent($query)
        ->addColumn('actions', '
                    <div class="float-right">
                        <a role="button"
                            class="btn btn-info btn-sm"
                            href="{{ route("productReport", "$id") }}">
                            <i class="bx bx-task bx-xs" style="color: white"></i>
                            Registros
                        </a>
                    </div>')
        ->addColumn('photo', function($products){
                    $path = asset($products->photo->source);
>>>>>>> database
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
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
=======
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Kardex"],
            ["name" => "Reportes"]
>>>>>>> database
        ];
        return view('pages.kardex', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
<<<<<<< HEAD
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function records($id)
    {
        $product = Products::select(['id', 'name', 'code', 'description'])->with(['first_image'])->where('id', $id)->first();

        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Kardex"],["name" => $product->name]
=======
     * List kardex report
     *
     * @return \Illuminate\Http\View
     */
    public function report($id)
    {
        $product = Product::select(['id', 'name', 'code', 'description'])->with(['photo'])->where('id', $id)->first();

        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Kardex"],
            ["name" => $product->name]
>>>>>>> database
        ];

        return view('pages.kardex.records', compact(['id', 'breadcrumbs', 'product']));
    }

<<<<<<< HEAD
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
=======
    public function getProductReport($id)
    {
        $report = KardexReport::getOpenedReport($id);

        if ($report) {
            $kardexItems = KardexItem::where('kardex_report_id', $report->id)->get();

            $finalObject = array();

            foreach ($kardexItems as $item) {
                $currentItem = array();

                if ($item->invoice == null) {
                    if ($item->is_initial == 1) {
                        $currentItem = ['tag' => 'Inventario inicial',
                            'e_quantity' => $item->quantity,
                            'e_unit_value' => $item->unit_value,
                            'e_value' => $item->value];
                    } else {
                        $currentItem = ['tag' => 'Movimiento desconocido'];
                    }
                } else {
                    if ($item->invoice->invoiceable_type == 'App\Models\Sale') {
                        $currentItem = ['tag' => 'Venta en factura ' . $item->invoice->invoice_num,
                            'e_quantity' => $item->quantity,
                            'e_unit_value' => $item->unit_value,
                            'e_value' => $item->value];
                    } else if ($item->invoice->invoiceable_type == 'App\Models\Purchase') {
                        $currentItem = ['tag' =>'Compra en factura ' . $item->invoice->invoice_num,
                            's_quantity' => $item->quantity,
                            's_unit_value' => $item->unit_value,
                            's_value' => $item->value];
                    } else {
                        $currentItem = ['tag' => 'Movimiento desconocido'];
                    }
                }

                $currentItem['final_stock'] = $item->final_stock;
                $currentItem['final_unit_value'] = $item->final_unit_value;
                $currentItem['final_value'] = $item->final_value;
                $currentItem['created_at'] = Carbon::parse($item->created_at)->format('d/m/Y');

                array_push($finalObject, $currentItem);
            }

            return Datatables::of($finalObject)->toJson();
        }
>>>>>>> database
    }
}
