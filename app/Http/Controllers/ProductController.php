<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('Admin.Product.products',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Product.products-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>  'required | unique:products',
            'code'      =>  'required | unique:products',
            'image'     =>  'required | mimes:jpeg,jpg,png,PNG | max:3000',
            'price'     =>  'required',
            'buyPrice'  =>  'required',

        ],[
            'name.required'     =>      'نام کالا وارد نشده',
            'name.unique'       =>      'این کالا قبلا ثبت شده',
            'code.required'     =>      'کدکالا وارد نشده',
            'code.unique'       =>      'این کد قبلا به کالایی دیگر اختصاص پیدا کرده',
            'image.required'    =>      'تصویری برای آپلود قرار داده نشده',
            'image.mimes'       =>      'شما مجاز به آپلود تصاویری با پسوند jpg,png هستید',
            'image.max'         =>      'شما مجاز به آپلود تصاویری با حجم 3 مگابایت هستید',
            'price.required'    =>      'قیمت کالا وارد نشده',
            'buyPrice.required' =>      'قیمت خرید کالا وارد نشده'
        ]);

        $product = Product::create([
          'name'          =>  $request->name,
          'code'          =>  $request->code,
          'price'         =>  $request->price,
          'buyPrice'      =>  $request->buyPrice,
          'description'   =>  $request->description,
          'status'        =>  $request->status,
          'messageStatus' =>  $request->message,
        ]);
        
        $media = $product->addMedia($request->File('image'))->toMediaCollection('productImage');
        $product->update(['image_id'=>$media->id]);
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
    public function edit($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        return view('Admin.Product.products-edit',compact('product'));
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

        $request->validate([
            'name'      =>  'required',
            'code'      =>  'required',
            'image'     =>  'mimes:jpeg,jpg,png,PNG | max:3000',
            'price'     =>  'required',
            'buyPrice'  =>  'required',

        ],[
            'name.required'     =>      'نام کالا وارد نشده',
            'code.required'     =>      'کدکالا وارد نشده',
            'image.mimes'       =>      'شما مجاز به آپلود تصاویری با پسوند jpg,png هستید',
            'image.max'         =>      'شما مجاز به آپلود تصاویری با حجم 3 مگابایت هستید',
            'price.required'    =>      'قیمت کالا وارد نشده',
            'buyPrice.required' =>      'قیمت خرید کالا وارد نشده'
        ]);

      $product = Product::findOrFail($id);

     
      $product->update([
        'name'          =>  $request->name,
        'code'          =>  $request->code,
        'price'         =>  $request->price,
        'buyPrice'      =>  $request->buyPrice,
        'description'   =>  $request->description,
        'status'        =>  $request->status,
        'messageStatus' =>  $request->message,
      ]);
      if($request->hasFile('image')){
        $media = $product->addMedia($request->File('image'))->toMediaCollection('productImage');
        $product->update(['image_id'=>$media->id]);
      }
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
        $productName = $product->name;
        Product::destroy($id);
        $message    =   'محصول '.$productName.' با موفقیت حذف شد';   
        return redirect()->route('products.index')->with('message',$message);
    }
    /*
    |--------------------------------------------------------------------------
    | Products Off Index Function
    |--------------------------------------------------------------------------
    |*/
    public function off_index($slug){
        $product = Product::where('slug',$slug)->firstOrFail();
        return view('Admin.Product.product-off',compact('product'));
    }
    /*
    |--------------------------------------------------------------------------
    | Products Off Store Function
    |--------------------------------------------------------------------------
    |*/
    public function off_store(Request $request){
        $product =  Product::findOrFail($request->product_id);
        $status = 'App\ProductOff'::where([
            ['product_id','=',$request->product_id],
            ['numberOfProduct','=',$request->numberOfProduct],
            ['offPrice','=',$request->offPrice]
        ])->exists();

        if($status == false){
            'App\ProductOff'::create([
                'product_id'        =>  $request->product_id,
                'numberOfProduct'   =>  $request->numberOfProduct,
                'offPrice'          =>  $request->offPrice
            ]);
            return redirect()->route('products.off',$product->slug)
            ->with('message','تخفیف با موفقیت برای این کالا ثبت شد');
        }else{
            return redirect()->route('products.off',$product->slug)
            ->with('error','این تعداد تخفیف با همین میزان تخفیف برای این کالا قبلا ثبت شده است');
        }
    }
        /*
        |--------------------------------------------------------------------------
        | Products Off Destroy Function
        |--------------------------------------------------------------------------
        |*/
        public function off_destroy($id){
            $off = 'App\ProductOff'::findOrFail($id);
            $product = Product::findOrFail($off->product_id);
            'App\ProductOff'::destroy($id);
            return redirect()->route('products.off',$product->slug)
            ->with('message','تخفیف مورد نظر حذف شد');
        }
        
    
}
