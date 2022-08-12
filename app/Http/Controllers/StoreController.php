<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Image;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_store(Request $request)
    {

        $validator = validator()->make(request()->all(), [
            'name'      => 'required | string | ',
            'email'     => 'required | email | ',
            'address'   => 'required | string',
            'phone'     => 'required | string',
            'status'    => 'required | integer',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $store = Store::create([
            'name'      => request()->get('name'),
            'email'     => request()->get('email'),
            'address'   => request()->get('address'),
            'phone'     => request()->get('phone'),
            'status'    => request()->get('status'),
        ]);
        $store->save();

        $user = User::find(request()->user_id)->update(['store_id' => $store->id]);

        $image = $request->file('banner');
        if ($request->hasFile('banner')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = new Image();
            $img->path = "/uploads/product_images/" . $new_name;
            $img->image_for = "store";
            $img->imagetable_type = "App\Models\Store";
            $img->imagetable_id = $store->id;



            $img->save();
        }

        $image = $request->file('brand');
        if ($request->hasFile('brand')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = new Image();
            $img->path = "/uploads/product_images/" . $new_name;
            $img->image_for = "Brand";
            $img->imagetable_type = "App\Models\Store";
            $img->imagetable_id = $store->id;



            $img->save();
        }


        return $user;
        /* $user->user_spec = 3;
        $user->store_id =  $store->id;
        $user->save(); */
    }

    public function getsstore($id)
    {
        $store = Store::with('storeToUser', 'images')->find($id);
        return $store;
    }

    public function updateStoreImages($id, Request $request)
    {

        $store = Store::with('images')->find($id);



        $image = $request->file('banner');

        if ($request->hasFile('banner')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = $store->images->where('image_for', 'store');

            if (File::exists($img[0]->path)) File::delete(public_path($img[0]->path));
            $img[0]->path = "/uploads/product_images/" . $new_name;
            $img[0]->image_for = "store";
            $img[0]->imagetable_type = "App\Models\Store";
            $img[0]->imagetable_id = $store->id;

            $store->images[0]->save();
        }

        $image = $request->file('logo');

        if ($request->hasFile('logo')) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product_images'), $new_name);

            $img = $store->images->where('image_for', 'brand');

            if (File::exists($img[0]->path)) File::delete(public_path($img[0]->path));
            $img[0]->path = "/uploads/product_images/" . $new_name;
            $img[0]->image_for = "brand";
            $img[0]->imagetable_type = "App\Models\Store";
            $img[0]->imagetable_id = $store->id;

            $store->images[0]->save();
        }
        return $store;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getsstores()
    {
        return Store::with('storeToUser')->get();
    }
    public function gets_pending_stores()
    {
        // ->where('status', '1')
        // products= Product::with('productToSub.subToMain')->get();
        $stores =  Store::with('storeToUser')->get();
        return $stores;
    }

    public function get_images($id)
    {
        $stores = Store::find($id)->load('images');

        return ($stores);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update_store(Request $request, $id)
    {
        $validator = validator()->make(request()->all(), [
            'name'      => request()->get('name'),
            'email'     => request()->get('email'),
            'address'   => request()->get('address'),
            'phone'     => request()->get('phone'),
            'status'    => request()->get('status'),

        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $getStore = Store::where('id', $id)->first();

        $getStore->name       = $request->name;
        $getStore->email      = $request->email;
        $getStore->address    = $request->address;
        $getStore->phone      = $request->phone;
        $getStore->status     = $request->status;

        return $getStore->save();
    }


    public function accept_store(Request $request, $id)
    {

        $getStore = Store::where('id', $id)->first();

        $getStore->status     = 2;
        $getStore->save();
        $theUser = User::whereId($request->user_id)->update(['user_spec' => 1]);

        // $theUser->user_spec   = 1;
        // $theUser->save();
        return $theUser;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy_store($id)
    {
        $delete_cat = Store::where('id', $id)->delete();
        User::where('store_id', $id)->update(['store_id' => 0]);
        return $delete_cat;
    }
}
