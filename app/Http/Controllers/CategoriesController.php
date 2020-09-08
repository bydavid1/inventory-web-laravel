<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function getRecords(){
        $query = Categories::where('is_deleted', '0');

        return datatables()->eloquent($query)
        ->addColumn('actions', '<div class="btn-group float-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editCategoryModal" onclick="update({{"$id"}})"><i class="fa fa-edit" style="color: white"></i></button>
                    <button type="button" class="btn btn-warning" onclick="remove({{"$id"}})"><i class="fa fa-trash" style="color: white"></i></button>
                    </div>')
        ->editColumn('is_available', function($categories){
            if ($categories->is_available == 1) {
                return '<i class="fa fa-check text-success"></i>';
            }else{
                return '<i class="fa fa-times text-danger"></i>';
            }
        })
        ->rawColumns(['actions', 'is_available'])
        ->toJson();
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
        return view('pages.categories', ['breadcrumbs'=>$breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Categories;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->is_available = 1;
        $category->is_deleted =0;

        $category->save();

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
        $result = Categories::where('id', $id)->get();

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
        $costumer = Categories::find($id);
        $costumer->name = $request->uname;
        $costumer->description = $request->udescription;

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
        $category = Categories::find($id);
        $category->is_deleted = 1;

        if ($category->save()) {
            return response(200);
        }else{
            return response(500);
        }
    }
}
