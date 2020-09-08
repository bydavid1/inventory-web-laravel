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
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Components"],["name" => "Alerts"]
        ];
        return view('pages.manufacturers', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {
        $manufacturers = Manufacturers::where('is_deleted', '0');
        return datatables()->eloquent($manufacturers)
        ->addColumn('actions', '<div class="btn-group float-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editManufacturerModal" onclick="update({{ $id }})"><i class="bx bx-edit" style="color: white"></i></button>
                    <button type="button" class="btn btn-warning" onclick="remove({{ $id }})"><i class="bx bx-trash" style="color: white"></i></button>
                    </div>')
        ->addColumn('image', '<img class="img-round" src="{{ asset($logo) }}"  style="max-height:50px; max-width:70px;"/>')
        ->addColumn('available', function($manufacturers){
            if ($manufacturers->is_available == 1) {
                return '<i class="bx bx-check fa-2x text-success"></i>';
            }else{
                return '<i class="bx bx-times fa-2x text-danger"></i>';
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

            if ($request->file('logo')) {
                $file = $request->file('logo');
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
        $result = Manufacturers::where('id', $id)->get();

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
        try {
            $find = Manufacturers::find($id);
            $find->name = $request->uname;
            //getLogo
            $savedImage = $find->logo;

            if ($request->file('ulogo')) {
                $file = $request->file('ulogo');
                $path = Storage::disk('public')->put('uploads', $file);
                $find->logo = $path;
            }
            
            if ($find->save() && $request->file('ulogo')) {
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
    public function delete($id)
    {
        $supplier = Manufacturers::find($id);
        $supplier->is_deleted = 1;

        if ($supplier->save()) {
            return response(200);
        }else{
            return response(500);
        }
    }
}
