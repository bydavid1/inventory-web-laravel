<?php

namespace App\Http\Controllers;

//error reporting
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use App\Manufacturers;
use Illuminate\Support\Facades\Storage;

class ManufacturersController extends Controller
{

    private $photo_default = "media/photo_default.png";

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manufacturers');
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $path = '';

            if ($request->file('imagepath')) {
                $file = $request->file('imagepath');
                $path = Storage::disk('public')->put('uploads', $file);
            }else{
                $path = $this->photo_default;
            }
    
            $new = new Manufacturers;
            $new->name = $request->name;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $find = Manufacturers::find($id);
            $find->name = $request->brandname;

            if ($request->file('brandlogo')) {
                $file = $request->file('brandlogo');
                $path = Storage::disk('public')->put('uploads', $file);
                $find->logo = $path;
            }
            
            if ($find->save() && $request->file('brandimage')) {
                if ($savedImage != $this->photo_default) {
                    unlink($savedImage);
                }
            }

            return response()->json(['success' => 'true', 'message' => 'Actualizado']);
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error: '. $e->getMessage()], 500);
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
        //
    }
}
