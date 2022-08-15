<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
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

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }



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
    public function get_products()
    {
        return Product::all()->load('images', 'category');
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
    public function update_product(Request $request, $id)
    {
        $request->all();

        $request->validate([
            'name' => 'required',
            'cat_id' => 'required|integer',
            'description' => 'required|'
        ], [
            'cat_id.integer' => 'Please Choose a category!!'
        ]);
        $request->all();
        $product = Product::find($id);

        $product->name                  = $request->name;
        $product->cat_id                = $request->cat_id;
        $product->description           = $request->description;
        $product->save();

        $image = $request->file('file1');
        if ($request->fileID1 == 0) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);
               Image::find($request->ids_0)->delete();

            $img1 = new Image() ;
            $img1->path = "/uploads/product_images/" . $new_name;
            $img1->image_for = "main";
            $img1->imagetable_type = "App\Models\Product";
            $img1->imagetable_id = $product->id;

            // $request->hasFile('file3')

            $img1->save();
        } else {

            $img1 = Image::find($request->fileID1);
            $img1->image_for = "main";
           $img1->save();
        }

        $image = $request->file('file2');
        if ($request->fileID2 == 0) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);
          Image::find($request->ids_1)->delete();
            $img2 = new Image() ;
            $img2->path = "/uploads/product_images/" . $new_name;
            $img2->image_for = "product";
            $img2->imagetable_type = "App\Models\Product";
            $img2->imagetable_id = $product->id;



            $img2->save();
        } else {
            $img2 = Image::find($request->fileID2);
            $img2->image_for = "product";
            $img2->save();
        }

        $image = $request->file('file3');
        if ($request->fileID3 == 0) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);
            Image::find($request->ids_2)->delete();
            $img3 = new Image() ;
            $img3->path = "/uploads/product_images/" . $new_name;
            $img3->image_for = "product";
            $img3->imagetable_type = "App\Models\Product";
            $img3->imagetable_id = $product->id;

            $img3->save();
            return response()->json($product);
        } else {
            $img3 = Image::find($request->fileID3);
            $img3->image_for = "product";
            $img3->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy_products($id)
    {

        $product = Product::find($id)->load('images');

        foreach ($product->images as $image) {

            if (file_exists($image->path)) {

                @unlink($image->path);
            }
            $image->delete();
        }

        return  $product->delete();
    }
}
