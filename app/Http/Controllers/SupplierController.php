<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Suppliers;
=======
use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
>>>>>>> database

class SupplierController extends Controller
{
    /**
<<<<<<< HEAD
     * Display a listing of the resource.
=======
     * Show view and send breadcrumb.
>>>>>>> database
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
<<<<<<< HEAD
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
=======
            ["link" => "/", "name" => "Home"],
            ["link" => "#", "name" => "Components"],
            ["name" => "Alerts"]
        ];

>>>>>>> database
        return view('pages.suppliers', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function getRecords()
    {
        return datatables()->eloquent(Suppliers::where('is_deleted', '0'))
        ->addColumn('actions', '<div class="btn-group float-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editSupplierModal" onclick="update({{"$id"}})"><i class="bx bx-edit" style="color: white"></i></button>
                    <button type="button" class="btn btn-warning" onclick="remove({{"$id"}})"><i class="bx bx-trash" style="color: white"></i></button>
                    </div>')
        ->rawColumns(['actions'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
=======
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Supplier::latest()->get();
            return DataTables::of($query)
            ->addColumn('actions', '
                        <div class="float-right">
                            <a href="#"
                                onclick="update({{"$id"}})"
                                data-toggle="modal"
                                data-target="#editSupplierModal">
                                <i class="badge-circle badge-circle-success
                                    bx bx-edit font-medium-1"
                                    style="color: white">
                                </i>
                            </a>
                            <a href="#"
                                onclick="remove({{"$id"}})">
                                <i class="badge-circle badge-circle-danger bx bx-trash font-medium-1"
                                    style="color: white">
                                </i>
                            </a>
                        </div>')
            ->rawColumns(['actions'])
            ->make();
        }
>>>>>>> database
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        $supplier = new Suppliers;
        $supplier->code = $request->code;
        $supplier->name = $request->name;
        $supplier->nit = $request->nit;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->is_available = 1;
        $supplier->is_deleted = 0;

        $supplier->save();

        return back()->with('mensaje', 'Guardado');
=======
        try {
            $supplier = new Supplier;
            $supplier->code = $request->code;
            $supplier->name = $request->name;
            $supplier->nit = $request->nit;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;

            if ($supplier->save()) {
                return response()->json(["message" => "Guardado satisfactoriamente"], 200);
            }

        } catch (Exception $e) {
            return response()->json(["message" => "Error al procesar la peticion"], 500);
        }
>>>>>>> database
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
<<<<<<< HEAD
        $result = Suppliers::where('id', $id)->get();

        if ($result->count() > 0) {
            return response($result, 200);
        }else{
            return response('Recurso no encontrado', 404);
=======
        $result = Supplier::find($id);

        if ($result) {
            return response($result, 200);
        }else{
            return response()->json(["message"=>"Recurso no encontrado"], 404);
>>>>>>> database
        }
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
<<<<<<< HEAD
        $costumer = Suppliers::find($id);
=======
        $costumer = Supplier::find($id);
>>>>>>> database
        $costumer->name = $request->uname;
        $costumer->nit = $request->unit;
        $costumer->address = $request->uaddress;
        $costumer->phone = $request->uphone;

        if ($costumer->save()) {
<<<<<<< HEAD
            return response(200);
        }else{
            return response(500);
=======
            return response()->json(["message"=>"Actualizado satisfactoriamente"], 200);
        }else{
            return response()->json(["message"=>"Error al procesar la peticion"], 500);
>>>>>>> database
        }
    }

    /**
     * Remove to trash
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
<<<<<<< HEAD
        $supplier = Suppliers::find($id);
        $supplier->is_deleted = 1;

        if ($supplier->save()) {
            return response(200);
        }else{
            return response(500);
=======
        try {
            $supplier = Supplier::find($id)->delete();

            if ($supplier) {
                return response()->json(["message"=>"Eliminado satisfactoriamente"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(["message"=>"Error al procesar la peticion"], 500);
>>>>>>> database
        }
    }
}
