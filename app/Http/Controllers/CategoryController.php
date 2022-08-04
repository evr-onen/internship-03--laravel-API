<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_category(Request $request)
    {
     
        $validator= validator()->make(request()->all(),[
            'name'      => 'required | string',
            'main_id'     => 'required | integer',
            

        ]);
        
        if($validator->fails()){
            return response($validator->errors());
            
        }
     
     
        $cat = Category::create([
            'name'           => request()-> get('name'),
            'main_id'        => request()-> get('main_id'),
        ]);
           
        return $cat->save();
    }
    

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getscategories(Category $category)
    {
        return Category::all();
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update_category(Request $request, $id)
    {
        $validator= validator()->make(request()->all(),[
            'name'      => 'required | string',
            'main_id'     => 'required | integer',
            

        ]);
        
        if($validator->fails()){
            return response($validator->errors());
        }

        $getcat=Category::where('id', $id)->first();

        $getcat->name = $request->name;
        $getcat->main_id = $request->main_id;
        
        return $getcat->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy_category(Category $category, $id)
    {
        $delete_cat=Category::where('id', $id)->delete();
        return $delete_cat;
    }
}
