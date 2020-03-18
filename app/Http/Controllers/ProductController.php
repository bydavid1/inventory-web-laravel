<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Products;
use App\Categories;
use App\Providers;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();;
        $providers = Providers::select(['id','name'])->where('is_available', 1)->get();;
        //->where('is_available', 1);
        return view('product.add', compact(['categories','providers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make(Request $request)
    {
        $new = new Products;
        $new->code = $request->code;
        $new->name = $request->name;
        $new->description = $request->description;
        $new->provider_id = $request->provider_id;
        $new->category_id = $request->category_id;
        $new->purchase = $request->purchase;
        $new->quantity = $request->quantity;
        $new->type = $request->type;
        $new->price1 = $request->price1;
        $new->price2 = $request->price2;
        $new->price3 = $request->price3;
        $new->price4 = $request->price4;
        $new->utility1 = $request->utility1;
        $new->utility2 = $request->utility2;
        $new->utility3 = $request->utility3;
        $new->utility4 = $request->utility4;
        $new->is_available = $request->is_available;
        $new->is_deleted = 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::findOrFail($id);

        return view('product.show', compact('product'));
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
