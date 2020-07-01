<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use App\Manufacturers;

class ManufacturersController extends Controller
{

    private $photo_default = "media/photo_default.png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getItems()
    {
        $manufacturers = Manufacturers::where('is_deleted', '0');
        return datatables()->eloquent($manufacturers)
        ->addColumn('actions', '<div class="btn-group float-right btn-group-sm">
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="editManufacturer({{ $id }})"><i class="fas fa-edit" style="color: white"></i></button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" onclick="removeManufacturer({{ $id }})"><i class="fas fa-trash" style="color: white"></i></button>
                    </div>')
        ->addColumn('image', '<img class="img-round" src="{{ asset($logo) }}"  style="max-height:50px; max-width:70px;"/>')
        ->addColumn('available', function($manufacturers){
            if ($manufacturers->is_available == 1) {
                return '<i class="fas fa-check text-success"></i>';
            }else{
                return '<i class="fas fa-times text-danger"></i>';
            }
        })
        ->rawColumns(['actions', 'available', 'image'])
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
        try {
            $path = '';

            if ($request->file('image')) {
                $file = $request->file('image');
                $path = Storage::disk('public')->put('uploads', $file);
            }else{
                $path = $this->photo_default;
            }
    
            $new = new Manufacturers;
            $new->name = $request->name2;
            $new->logo = $path;
            $new->is_available = 1;
            $new->is_deleted = 0;

            if ($new->save()) {
                return response()->json(['success'=>'true', 'message'=>'Guardado']);
            }else{
                return response()->json(['success'=>'false', 'message'=>'No se pudo guardar']);
            }
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
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
        $find = Manufacturers::findOrFail($id);
        return response()->json(['success'=>'false', 'data'=> $find]);
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
