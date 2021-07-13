<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    /**
     * Show view and send breadcrumb.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Inicio"],
            ["link" => "#", "name" => "Inventario"],
            ["name" => "Categorías"]
        ];

        return view('pages.categories', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function getRecords(Request $request){
        if ($request->ajax()) {
            $query = Category::latest()->get();

            return DataTables::of($query)
            ->addColumn('actions', '<div class="btn-group float-right">
                            <button type="button" 
                                class="btn btn-danger" 
                                data-toggle="modal" 
                                data-target="#editCategoryModal" 
                                onclick="update({{"$id"}})">
                                <i class="bx bx-edit" style="color: white"></i>
                            </button>
                            <button type="button" 
                                class="btn btn-warning" 
                                onclick="remove({{"$id"}})">
                                <i class="bx bx-trash" style="color: white"></i>
                            </button>
                        </div>')
            ->editColumn('is_available', function($category){
                if ($category->is_available == 1) {
                    return '<i class="bx bxs-check-circle text-success"></i>';
                }else{
                    return '<i class="bx bxs-x-circle text-danger" ></i>';
                }
            })
            ->rawColumns(['actions', 'is_available'])
            ->make();
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
            $category = new Category;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->is_available = 1;

            $category->save();

            return response()->json(["message"=>"Categoría guardada"], 200);
        } catch (Exception $th) {
            return response()->json(["message"=>"Error en el servidor, intentelo mas tarde"], 500);
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
        $result = Category::find($id);

        if ($result) {
            return response($result, 200);
        }else{
            return response()->json(["message" => "Recurso no encontrado"], 404);
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
        $costumer = Category::find($id);
        $costumer->name = $request->uname;
        $costumer->description = $request->udescription;

        if ($costumer->save()) {
            return response()->json(["message" => "Actualizacion satisfactoria"], 200);
        }else{
            return response()->json(["message" => "Error al procesar los datos"], 500);
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
            $category = Category::find($id)->delete();

            if ($category) {
                return response()->json(["message" => "Enviado a la papelera"], 200);
            }

        } catch (Exception $e) {
            return response()->json(["message" => "Error al procesar la peticion"], 500);
        }
    }
}
