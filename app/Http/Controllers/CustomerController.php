<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
=======
use App\Models\Customer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
>>>>>>> database

class CustomerController extends Controller
{

    /**
     * Api routes
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function getRecords()
    {
        return datatables()->eloquent(Customers::where('is_deleted', '0'))
        ->addColumn('actions', '<div>
        <a href="" data-toggle="modal" onclick="update({{"$id"}})" data-target="#editCostumer">
            <i class="badge-circle badge-circle-success bx bx-edit font-medium-1" style="color: white"></i>
        </a>
        <a href="#" onclick="remove({{"$id"}})"><i class="badge-circle badge-circle-danger bx bx-trash font-medium-1" style="color: white"></i></a>
        </div>')
        ->rawColumns(['actions'])
        ->toJson();
=======
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
>>>>>>> database
    }

    public function byQuery($query)
    {
<<<<<<< HEAD
        $result = Customers::select('id', 'name', 'nit')->where('name', 'like', "%". $query ."%")->get();
=======
        $result = Customer::select('id', 'name', 'nit')->where('name', 'like', "%". $query ."%")->get();
>>>>>>> database

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
            ["link" => "/home", "name" => "Home"],
            ["name" => "Clientes"]
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
<<<<<<< HEAD
        $costumer = new Customers;
=======
        $costumer = new Customer;
>>>>>>> database
        $costumer->code = $request->code;
        $costumer->name = $request->name;
        $costumer->phone = $request->phone;
        $costumer->email = $request->email;
        $costumer->address = $request->address;
        $costumer->nit = $request->nit;
<<<<<<< HEAD
        $costumer->is_deleted = '0';
=======
>>>>>>> database

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
<<<<<<< HEAD
        $result = Customers::where('id', $id)->get();
=======
        $result = Customer::where('id', $id)->get();
>>>>>>> database

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
<<<<<<< HEAD
        $costumer = Customers::find($id);
=======
        $costumer = Customer::find($id);
>>>>>>> database
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
<<<<<<< HEAD
        $costumer = Customers::find($id);
        $costumer->is_deleted = 1;

        if ($costumer->save()) {
            return response(200);
        }else{
            return response(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $costumer = Customers::find($id);
        if ($costumer->delete()) {
            return back()->with('mensaje', 'Cliente editado');
=======
        try {
            $costumer = Customer::find($id);
            $costumer->delete();

            return response()->json(["message" => "Cliente eliminado"], 201);
        } catch (Exception $th) {
            return response()->json(["message" => "Error al procesar la peticion"], 500);
>>>>>>> database
        }
    }
}
