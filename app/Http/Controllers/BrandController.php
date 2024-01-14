<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    private $photo_default = "assets/media/photo_default.png";

    /**
     * Show view and send breadcrumb.
     *
     * @return View
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/home", "name" => "Home"],
            ["link" => "#", "name" => "Inventario"],
            ["name" => "Marcas"]
        ];

        return view('pages.brands.index', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Datatables
     */
    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::latest()->get();

            return DataTables::of($brands)
            ->addColumn('actions', 'components.brands.actions')
            ->addColumn('image', '<img class="img-round" src="{{ $logo }}" style="max-height: 50px; max-width: 70px;"/>')
            ->addColumn('available', 'components.brands.available')
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
            $new->logo = 'storage/' . $path;
            $new->is_available = 1;

            if ($new->save()) {
                return response()->json(['message' => 'Guardado'], 201);
            }else{
                return response()->json(['message' => 'No se pudo guardar'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: '. $e->getMessage()], 500);
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
            return response()->json(['message' => 'Recurso no encontrado'], 404);
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
                $find->logo = 'storage/' . $path;
            }

            if ($find->save() && $request->file('ulogo')) {
                if ($savedImage != $this->photo_default) {
                    unlink($savedImage);
                }
            }

            return response()->json(['message' => 'Actualizado'], 200);
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
        try {
            $brand = Brand::find($id)->delete();

            if ($brand) {
                return response()->json(["message" => "Enviado a la papelera"], 200);
            }

        } catch (Exception $e) {
            return response()->json(["message" => "Error al procesar la peticion"], 500);
        }
    }
}
