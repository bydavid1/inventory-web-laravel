<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    private $photo_default = "default.png";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [["link" => "/", "name" => "Home"],["link" => "#", "name" => "Inventario"],["name" => "Marcas"]];
        return view('pages.brands', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $brand = Brand::latest()->get();
            return DataTables::of($brand)
            ->addColumn('actions', '<div class="btn-group float-right">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editManufacturerModal" onclick="update({{ $id }})"><i class="bx bx-edit" style="color: white"></i></button>
                        <button type="button" class="btn btn-warning" onclick="remove({{ $id }})"><i class="bx bx-trash" style="color: white"></i></button>
                        </div>')
            ->addColumn('image', '<img class="img-round" src="{{ asset("storage/" . $logo) }}"  style="max-height:50px; max-width:70px;"/>')
            ->addColumn('available', function($brand){
                if ($brand->is_available == 1) {
                    return '<i class="bx bx-check fa-2x text-success"></i>';
                }else{
                    return '<i class="bx bx-times fa-2x text-danger"></i>';
                }
            })
            ->rawColumns(['actions', 'available', 'image'])
            ->toJson();
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
            $path = '';

            if ($request->file('logo')) {
                $file = $request->file('logo');
                $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);

            }else{
                $path = $this->photo_default;
            }

            $new = new Brand;
            $new->name = $request->name;
            $new->logo = $path;
            $new->is_available = 1;

            if ($new->save()) {
                return response()->json(['success'=>'true', 'message'=>'Guardado'], 200);
            }else{
                return response()->json(['success'=>'false', 'message'=>'No se pudo guardar'], 500);
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
        $result = Brand::find($id);

        if ($result) {
            return response($result, 200);
        }else{
            return response()->json(['success'=>'false', 'message'=>'No se pudo guardar'], 500);
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
            $find = Brand::find($id);
            $find->name = $request->uname;
            //getLogo
            $savedImage = $find->logo;

            if ($request->file('ulogo')) {
                $file = $request->file('ulogo');
                $path = substr(Storage::disk('public')->put('storage/uploads', $file), 8);
                $find->logo = $path;
            }

            if ($find->save() && $request->file('ulogo')) {
                if ($savedImage != $this->photo_default) {
                    unlink($savedImage);
                }
            }

            return response()->json(['success' => 'true', 'message' => 'Actualizado'], 200);
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
        $brand = Brand::find($id)->delete();

        if ($brand) {
            return response()->json(["message"=>"Enviado a la papelera"], 200);
        }else{
            return response()->json(["message"=>"Error al procesar la peticion"], 500);
        }
    }
}
