<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('Admin.products',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/products-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $image = Storage::disk('public')->put('Product/'.date('Y/m'),$request->File('image'));
        Product::create([
          'name'          =>  $request->name,
          'code'          =>  $request->code,
          'image'         =>  $image,
          'price'         =>  $request->price,
          'buyPrice'      =>  $request->buyPrice,
          'description'   =>  $request->description,
          'status'        =>  $request->status,
          'messageStatus' =>  $request->message,
        ]);

        return redirect()->route('products.index');
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
        $product = Product::findOrFail($id);
        return view('Admin.products-edit',compact('product'));
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
      $product = Product::findOrFail($id);

      if(is_null($request->File('image'))){
        $image = $product->image;
      }else{
        Storage::disk('public')->delete($product->image);
        $image = Storage::disk('public')->put('Product/'.date('Y/m'),$request->File('image'));
      }
      $product->update([
        'name'          =>  $request->name,
        'code'          =>  $request->code,
        'image'         =>  $image,
        'price'         =>  $request->price,
        'buyPrice'      =>  $request->buyPrice,
        'description'   =>  $request->description,
        'status'        =>  $request->status,
        'messageStatus' =>  $request->message,
      ]);

      return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete($product->image);
        Product::destroy($id);
        return redirect()->route('products.index');
    }
}
