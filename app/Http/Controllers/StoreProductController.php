<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
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
        $validator = validator()->make(request()->all(), [
            'store_id'      => 'required | integer',
            'product_id'    => 'required | string',
            'price'         => 'required | string',
            'stock'         => 'required | string',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }


        $request->all();

        $storepro = new StoreProduct();
        $storepro->store_id    = $request->store_id;
        $storepro->product_id  = $request->product_id;
        $storepro->price       = $request->price;
        $storepro->stock       = $request->stock;

        $storepro->save();

        return StoreProduct::find($storepro->id)->with('storeToProduct.images')->get();
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
     * @param  \App\Models\StoreProduct  $storeProduct
     * @return \Illuminate\Http\Response
     */
    public function getstoreProducts(Request $request )
    {

        $stores=StoreProduct::with('storeToProduct.images')->where('store_id', $request)->get();
        return  $stores;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoreProduct  $storeProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreProduct $storeProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreProduct  $storeProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreProduct $storeProduct, $id)
    {
        $validator = validator()->make(request()->all(), [
            'store_id'      => 'required | integer',
            'product_id'    => 'required | integer',
            'price'         => 'required | integer',
            'stock'         => 'required | string',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }


        $request->all();

        $storepro = StoreProduct::find($id);
        $storepro->store_id    = $request->store_id;
        $storepro->product_id  = $request->product_id;
        $storepro->price       = $request->price;
        $storepro->stock       = $request->stock;
        $storepro->save();


        return StoreProduct::where('store_id', $storepro->store_id)->with('storeToProduct.images')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreProduct  $storeProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreProduct $storeProduct, $id)
    {
        $item = StoreProduct::find($id)->store_id;
        $delete = StoreProduct::find($id)->delete();
        return StoreProduct::where('store_id', $item)->with('storeToProduct.images')->get();
    }
}
