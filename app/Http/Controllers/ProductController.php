<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Image;

class ProductController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth:api');
    } */



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return $request->name;
        $request->all();

        $request->validate([
            'name' => 'required',
            'cat_id' => 'required|integer',
            'description' => 'required|'
        ], [
            'cat_id.integer' => 'Please Choose a category!!'
        ]);
        $request->all();
        $product = new Product();

        $product->name                  = $request->name;
        $product->cat_id                = $request->cat_id;
        $product->description           = $request->description;
        $product->save();
        $image = $request->file('file1');
        if ($request->hasFile('file1')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = new Image();
            $img->path = "/uploads/product_images/" . $new_name;
            $img->image_for = "main";
            $img->imagetable_type = "App\Models\Product";
            $img->imagetable_id = $product->id;



            $img->save();
        } else {
            $product->save();
            return response()->json('photo yok');
        }

        $image = $request->file('file2');
        if ($request->hasFile('file2')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = new Image();
            $img->path = "/uploads/product_images/" . $new_name;
            $img->image_for = "product";
            $img->imagetable_type = "App\Models\Product";
            $img->imagetable_id = $product->id;



            $img->save();
        } else {
            $product->save();
            return response()->json('photo yok');
        }

        $image = $request->file('file3');
        if ($request->hasFile('file3')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = new Image();
            $img->path = "/uploads/product_images/" . $new_name;
            $img->image_for = "product";
            $img->imagetable_type = "App\Models\Product";
            $img->imagetable_id = $product->id;



            $img->save();
            return response()->json($product);
        } else {
            $product->save();
            return response()->json('photo yok');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
