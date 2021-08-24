<?php

namespace App\Http\Controllers;

use App\Models\KardexItem;
use App\Models\KardexReport;
use App\Models\Product;
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
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Kardex"],
            ["name" => "Reportes"]
        ];
        return view('pages.kardex', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
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
        ];

        return view('pages.kardex.records', compact(['id', 'breadcrumbs', 'product']));
    }

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
    }
}
