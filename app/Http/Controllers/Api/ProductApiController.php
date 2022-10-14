<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use DB;


class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return Product::with('type', 'types', 'attachment')->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required',
            'detail' => 'required',
            'type'=> 'required',
            'attachment'=> 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240',
        ]);

        $path = $request->file('attachment')->store('attachments', 'public');

        DB::beginTransaction();

        $product = Product::create($request -> all());
        $product->type()->create(([
            'name'=>$request->type,
        ]));

        $product->attachment()->create(([
            'path'=>$path,
        ]));

        DB::commit();

        return $product->load('type', 'attachment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            
        ]);

        $product->name = $request->name;
        $product->detail = $request->detail;

        $product->save();

        return $product;

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }
}
