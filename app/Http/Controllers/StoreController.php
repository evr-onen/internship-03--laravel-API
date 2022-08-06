<?php

namespace App\Http\Controllers;

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
        return $user;
        /* $user->user_spec = 3;
        $user->store_id =  $store->id;
        $user->save(); */
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getsstores()
    {
        return Store::all();
    }
    public function gets_pending_stores()
    {

        // products= Product::with('productToSub.subToMain')->get();
        $stores =  Store::with('storeToUser')->where('status', '1')->get();
        return $stores;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy_store($id)
    {
        $delete_cat = Store::where('id', $id)->delete();
        return $delete_cat;
    }
}
