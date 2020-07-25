<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Costumers;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('costumers');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $costumer = new Costumers;
        $costumer->code = $request->code;
        $costumer->name = $request->name;
        $costumer->phone = $request->phone;
        $costumer->email = $request->email;
        $costumer->address = $request->address;
        $costumer->nit = $request->nit;
        $costumer->is_deleted = '0';

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
        $result = Costumers::where('id', $id)->get();

        if ($result->count() > 0) {
            return response($result, 200);
        }else{
            return response('Recurso no encontrado', 404);
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
            $costumer = Costumers::find($id);
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
        $costumer = Costumers::find($id);
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
        $costumer = Costumers::find($id);
        if ($costumer->delete()) {
            return back()->with('mensaje', 'Cliente editado');
        }
    }
}
