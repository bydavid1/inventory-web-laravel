<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{

    /**
     * Api routes
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Customer::latest()->get();

            return DataTables::of($query)
                ->addColumn('actions', '
                    <div class="float-right">
                        <a href="#"
                            data-toggle="modal"
                            onclick="update({{"$id"}})"
                            data-target="#editCostumer">
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
                ->editColumn('created_at', function($customer) {
                    return Carbon::parse($customer->created_at)->format("d-m-Y");
                })
                ->rawColumns(['actions'])
                ->make();
        }
    }

    public function byQuery($query)
    {
        $result = Customer::select('id', 'name', 'nit')->where('name', 'like', "%". $query ."%")->get();

        if ($result->count() > 0) {
           return response()->json(['success' => true, 'data' => $result], 200);
        }else{
           return response()->json(['success' => false, 'data' => null], 200);
        }
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
        return view('pages.customers', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $costumer = new Customer;
        $costumer->code = $request->code;
        $costumer->name = $request->name;
        $costumer->phone = $request->phone;
        $costumer->email = $request->email;
        $costumer->address = $request->address;
        $costumer->nit = $request->nit;

        if($costumer->save()){
            return back()->with('mensaje', 'Cliente creado');
        }else{
            return back()->with('mensaje', 'Ocurrió un error');
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
        $result = Customer::where('id', $id)->get();

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
        $costumer = Customer::find($id);
        $costumer->email = $request->uemail;
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
        try {
            $costumer = Customer::find($id);
            $costumer->delete();

            return response()->json(["message" => "Cliente eliminado"], 201);
        } catch (Exception $th) {
            return response()->json(["message" => "Error al procesar la peticion"], 500);
        }
    }
}
