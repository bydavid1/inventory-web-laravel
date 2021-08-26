<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Show view and send breadcrumb.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/home", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["name" => "Proveedores"]
        ];

        return view('pages.suppliers', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Supplier::find($id);

        if ($result) {
            return response($result, 200);
        }else{
            return response()->json(["message"=>"Recurso no encontrado"], 404);
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
        $costumer = Supplier::find($id);
        $costumer->name = $request->uname;
        $costumer->nit = $request->unit;
        $costumer->address = $request->uaddress;
        $costumer->phone = $request->uphone;

        if ($costumer->save()) {
            return response()->json(["message"=>"Actualizado satisfactoriamente"], 200);
        }else{
            return response()->json(["message"=>"Error al procesar la peticion"], 500);
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
        try {
            $supplier = Supplier::find($id)->delete();

            if ($supplier) {
                return response()->json(["message"=>"Eliminado satisfactoriamente"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(["message"=>"Error al procesar la peticion"], 500);
        }
    }
}
