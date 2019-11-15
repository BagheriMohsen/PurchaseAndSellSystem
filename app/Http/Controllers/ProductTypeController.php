<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductType;
class ProductTypeController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ProductType::create([
          'user_id'     =>  auth()->user()->id,
          'product_id'  =>  $request->product,
          'name'        =>  $request->name
        ]);
        $product = 'App\Product'::findOrFail($request->product);
        $message = $request->name.' به محصول '.$product->name.' اضافه شد ';
        // return redirect()->route('products.index')->with('message',$message);
        return $message;
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
      $type = ProductType::findOrFail($id);
      $type->update([
        'user_id'     =>  auth()->user()->id,
        'product_id'  =>  $request->product,
        'name'        =>  $request->name
      ]);
      $product = 'App\Product'::findOrFail($request->product);
      $message = $request->name.' زیر مجموعه محصول '.$product->name.' به روز رسانی شد ';

    //   return redirect()->route('products.index')->with('message',$message);
        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productType    = ProductType::findOrFail($id);
        $typeName       =   $productType->name;
        $product        = 'App\Product'::findOrFail($productType->product_id);
        ProductType::destroy($id);
        $message = $typeName.' از زیر مجموعه محصول '.$product->name.' حذف شد ';
        // return redirect()->route('products.index')->with('message',$message);
        return $message;
    }
}
