<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
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
        $path = '';

        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'purchase' => 'required',
            'quantity' => 'required',
            'price1' => 'required'
        ]);


        if ($request->file('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->put('uploads', $file);
        }else{
            $path = "media/photo_default.png";
        }

        if ($request->price2 == '') {
            $request->price2 = 0.00;
            $request->utility2 = 0.00;
        }
        if ($request->price3 == '') {
            $request->price3 = 0.00;
            $request->utility3 = 0.00;
        }
        if ($request->price4 == '') {
            $request->price4 = 0.00;
            $request->utility4 = 0.00;
        }
        if ($request->description == '') {
            $request->description = 'No hay descripción';
        }
        
        $new = new Products;
        $new->code = $request->code;
        $new->name = $request->name;
        $new->image = $path;
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

        $new->save();

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
        $categories = Categories::select(['id','name'])->where('is_available', 1)->get();;
        $providers = Providers::select(['id','name'])->where('is_available', 1)->get();;
        $product = Products::findOrfail($id);
        return view('product.edit', compact(['product', 'categories', 'providers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){ 
        $product = Products::find($id);
        //Salvo el path de la imagen por si luego es necesario eliminarlo
        $savedImage = $product->image;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->provider_id = $request->provider_id;
        $product->category_id = $request->category_id;
        $product->purchase = $request->purchase;
        $product->quantity = $request->quantity;
        $product->type = $request->type;
        $product->price1 = $request->price1;
        $product->price2 = $request->price2;
        $product->price3 = $request->price3;
        $product->price4 = $request->price4;
        $product->utility1 = $request->utility1;
        $product->utility2 = $request->utility2;
        $product->utility3 = $request->utility3;
        $product->utility4 = $request->utility4;
        $product->is_available = $request->is_available;
        $product->is_deleted = 0;
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->put('uploads', $file);
            $product->image = $path;
        }
        $product->save();
        if ($request->file('image')) {
            unlink($savedImage);
        }
        return back()->with('mensaje', 'Registro actualizado exitosamente');
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
