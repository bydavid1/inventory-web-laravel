<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
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
        return view('pages.suppliers', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        return datatables()->eloquent(Supplier::where('is_deleted', '0'))
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = new Supplier;
        $supplier->code = $request->code;
        $supplier->name = $request->name;
        $supplier->nit = $request->nit;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->is_available = 1;
        $supplier->is_deleted = 0;

        $supplier->save();

        return back()->with('mensaje', 'Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Supplier::where('id', $id)->get();

        if ($result->count() > 0) {
            return response($result, 200);
        }else{
            return response('Recurso no encontrado', 404);
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
            return response(200);
        }else{
            return response(500);
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
        $supplier = Supplier::find($id);
        $supplier->is_deleted = 1;

        if ($supplier->save()) {
            return response(200);
        }else{
            return response(500);
        }
    }
}
