<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suppliers;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('suppliers');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        return datatables()->eloquent(Suppliers::query())
        ->addColumn('actions', '<div class="btn-group float-right btn-group-sm">
                    <a type="button" class="btn btn-danger" href="{{ route("editProduct", "$id") }}"><i class="fas fa-edit" style="color: white"></i></a>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct()"><i class="fas fa-trash" style="color: white"></i></button>
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
