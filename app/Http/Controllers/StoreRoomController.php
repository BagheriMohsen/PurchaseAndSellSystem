<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreRoom;
class StoreRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();
        
        if($role == "mainWarehouser"){
            /* ------------------Cost,ProductNumber-------------------- */
        $rooms = StoreRoom::where(['in_out'=>'in','warehouse_id'=>1])->get();
        $cost = 0;
        $allProduct = 0;
        foreach($rooms as $room){
            $cost += $room->product->price * $room->number;
            $allProduct += $room->number;
        }
        /* ------------------Cost,ProductNumber-------------------- */
            $storeRooms = StoreRoom::where('warehouse_id',1)->latest()->paginate(10)->unique('product_id');
            return view('Admin.StoreRoom.storeRoom-index',compact(
                'storeRooms',
                'cost',
                'allProduct'
            ));

        }elseif($role == "fundWarehouser"){
            /* ------------------Cost,ProductNumber-------------------- */
            $rooms = StoreRoom::where(['in_out'=>'in','warehouse_id'=>2])->get();
            $cost = 0;
            $allProduct = 0;
            foreach($rooms as $room){
                $cost += $room->product->price * $room->number;
                $allProduct += $room->number;
            }
        /* ------------------Cost,ProductNumber-------------------- */
            $storeRooms = StoreRoom::where('warehouse_id',2)->latest()->paginate(10);
            return view('Admin.StoreRoom.storeRoom-index',compact(
                'storeRooms',
                'cost',
                'allProduct'
            ));
        }else{
            return abort(404);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = 'App\Product'::latest()->get();
        return view('Admin.StoreRoom.storeRoom-create',compact('products'));
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
            'product'       =>  'required',
            'number'        =>  'required',
            'status'        =>  'required',
            'in_out'        =>  'required'
        ],[
            'product.required'  =>  'محصولی انتخاب نشده',
            'number.required'   =>  'تعداد محصول را وارد کنید',
            'status.required'   =>  'یکی از وضعیت ها را باید انتخاب کنید',
            'in_out.required'   =>  'گزینه ای از ورود و خروج هنوز فعال نشده'
        ]);


        
            StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'warehouse_id'  =>  1,
                'product_id'    =>  $request->product,
                'number'        =>  $request->number,
                'decription'    =>  $request->decription,
                'status'        =>  $request->status,
                'in_out'        =>  $request->in_out
            ]);
            $product = 'App\Product'::findOrFail($request->product);
            if($request->in_out == "in"){
                $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد به انبار مادر افزوده شد ';
            }elseif($request->in_out == "out"){
                $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد از انبار خارج شد ';
            }else{
                $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد به انبار تنخواه افزوده شد ';
            }
            return redirect()->route('storeRooms.index')->with('message',$message);
       
        

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
    /*
    |--------------------------------------------------------------------------
    | List of product (IN)
    |--------------------------------------------------------------------------
    |*/
    public function inStorage(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>'in'])->latest()->paginate(10);
            return view('Admin.StoreRoom.inStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'in'])->latest()->paginate(10);
            return view('Admin.StoreRoom.inStorage',compact('storeRooms'));
        }else{
            return abort(404);
        }

    }
    /*
    |--------------------------------------------------------------------------
    | List of product (OUT)
    |--------------------------------------------------------------------------
    |*/
    public function outStorage(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>'out'])->latest()->paginate(10);
            return view('Admin.StoreRoom.outStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'out'])->latest()->paginate(10);
            return view('Admin.StoreRoom.outStorage',compact('storeRooms'));
        }else{
            return abort(404);
        }
    }
}
