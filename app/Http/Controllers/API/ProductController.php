<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Log;
use Intervention\Image\Facades\Image; 
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('categories')->latest()->paginate(10);
        // return $prod;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'store'=>'required',
            'product_name'=>'required',
            'price'=>'required',
            'supplier_link'=>'required',
            'status'=>'required'
        ]);
        if (empty($request->input('category_id'))){
             $this->validate($request, [
               'category_name' => 'required',
             ]);
        }
        if (empty($request->input('category_name'))){
             $this->validate($request, [
               'category_id' => 'required',
             ]);
        }
        DB::beginTransaction();
        $category = "";
        if(!empty($request->input('category_name')))
        {
            $get_id = Category::create([
                'category_name' => $request['category_name'],
                'status' => $request['status'],
            ]); 
            $category = $get_id->id;
        }else{
            $category = $request['category_id'];
        }
        try {
            $name = time().'.' . explode('/', explode(':', substr($request->thumbnail, 0, strpos($request->thumbnail, ';')))[1])[1];
            \Image::make($request->thumbnail)->save(public_path('images/products/').$name);
            $request->merge(['thumbnail' => $name]);
            $product =  Product::create([
                'store' => $request['store'],
                'product_name' => $request['product_name'],
                'price' => $request['price'],
                'profit' => $request['profit'],
                'thumbnail' => $request['thumbnail'],
                'category_id' => $category,
                'product_link' => $request['product_link'],
                'supplier_link' => $request['supplier_link'],
                'status' => $request['status'],
            ]); 

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
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
