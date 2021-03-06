<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


use App\Models\StoreRoom;
use App\Models\User;
use App\Models\Product;
use App\Models\Transport;
// in this file exists App\Storage

class StoreRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = User::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storages = 'App\Models\Storage'::where('warehouse_id',1)->get();
            $allProduct = 'App\Models\Storage'::where('warehouse_id',1)->sum('number');
            
            
        }else{
            $storages = 'App\Models\Storage'::where('warehouse_id',2)->get();
            $allProduct = 'App\Models\Storage'::where('warehouse_id',2)->sum('number');
           
        }
       
        return view('Admin.StoreRoom.storeRoom-index',compact('storages','allProduct'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status','active')->latest()->get();
        return view('Admin.StoreRoom.Main.storeRoom-create',compact('products'));
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
    | IN Manage (IN)
    |--------------------------------------------------------------------------
    |*/
    public function inManage(Request $request){
        $request->validate([
            'product'       =>  'required',
            'number'        =>  'required',
            'status'        =>  'required',
        ],[
            'product.required'  =>  'محصولی انتخاب نشده',
            'number.required'   =>  'تعداد محصول را وارد کنید',
            'status.required'   =>  'یکی از وضعیت ها را باید انتخاب کنید',
        ]);

        $status = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',1]
        ])->exists();
        
            /*(IN) IF product is exist in storage table*/
            if($status == true){
                $storage = 'App\Models\Storage'::where([
                    ['product_id','=',$request->product],
                    ['warehouse_id','=',1]
                ])->firstOrFail();

                $number = $storage->number + $request->number;
                $storage->update(['number'=>$number]);
                /*store product in store Room(in_out)*/
                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'in_date'       =>  Carbon::now(),
                    'in_out'        =>  1
                ]);
            }else{
                /*IF product is not exist in storage table*/
                $storage = 'App\Models\Storage'::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number
                ]);
                /*store product in store Room(in_out)*/
                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'in_date'       =>  Carbon::now(),
                    'in_out'        =>  1
                ]);

            }

            $product = Product::findOrFail($request->product);
           
            $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد به انبار مادر افزوده شد ';
            
            return redirect()->route('storeRooms.index')->with('message',$message);
    }
    /*
    |--------------------------------------------------------------------------
    | OUT Manage (OUT)
    |--------------------------------------------------------------------------
    |*/
    public function outManage(Request $request){
            $request->validate([
                'product'       =>  'required',
                'number'        =>  'required',
                'status'        =>  'required',
            ],[
                'product.required'  =>  'محصولی انتخاب نشده',
                'number.required'   =>  'تعداد محصول را وارد کنید',
                'status.required'   =>  'یکی از وضعیت ها را باید انتخاب کنید',
            ]);

            $status = 'App\Models\Storage'::where([
                ['product_id','=',$request->product],
                ['warehouse_id','=',1]
            ])->exists();

            

            /*(OUT) IF product is exist in storage table */
            if($status == true){
                $storage = 'App\Models\Storage'::where([
                    ['product_id','=',$request->product],
                    ['warehouse_id','=',1]
                ])->firstOrFail();

                if($storage->number < $request->number){
                    $message = " این تعداد ".$storage->product->name." در انبار موجود نیست"." از این کالا در انبار".$storage->number." عدد وجود دارد";
                    return back()->with('info',$message);
                }

                

                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'out_date'      =>  Carbon::now(),
                    'in_out'        =>  3
                ]);

            if($storage->number >= $request->number){
                $number = $storage->number - $request->number;
                $storage->update(['number'=>$number]);
            }
        }else{
            return back()->with('info','این کالا در انبار موجود نیست');
        }


        $product = Product::findOrFail($request->product);
            
        $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد از انبار خارج شد ';
        
        return redirect()->route('storeRooms.index')->with('message',$message);
   }
    /*
    |--------------------------------------------------------------------------
    | Storage Change (OUT)
    |--------------------------------------------------------------------------
    |*/
   public function storageChange(Request $request){

        $request->validate([
            'product'       =>  'required',
            'number'        =>  'required',
            'status'        =>  'required',
        ],[
            'product.required'  =>  'محصولی انتخاب نشده',
            'number.required'   =>  'تعداد محصول را وارد کنید',
            'status.required'   =>  'یکی از وضعیت ها را باید انتخاب کنید',
        ]);

        $status = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',1]
        ])->exists();
         /*(ANBAR) IF product is exist in storage table*/
        if($status == true){
            $storage = 'App\Models\Storage'::where([
                ['product_id','=',$request->product],
                ['warehouse_id','=',1]
            ])->firstOrFail();
            if($storage->number >= $request->number){
                $number = $storage->number - $request->number;
                $storage->update(['number'=>$number]);
                
                /*store product in store Room(in_out)*/
                // mainWarehouse
                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'receiver_id'   =>  2,
                    'sender_id'     =>  1,
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  'به انبار تنخواه',
                    'in_out'        =>  2
                ]);
                // fundWarehouse
                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  2,
                    'receiver_id'   =>  2,
                    'sender_id'     =>  1,
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  'از انبار مادر',
                    'in_out'        =>  5
                ]);

            }else{
                $message = " این تعداد ".$storage->product->name." در انبار موجود نیست "." از این کالا در انبار ".$storage->number." عدد وجود دارد";
                return back()->with('info',$message);
            }
        }else{
            return back()->with('info','این کالا در انبار موجود نیست');
        }
        $product = Product::findOrFail($request->product);
            
        $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد به انبار تنخواه منتقل شد ';
        
        return redirect()->route('storeRooms.index')->with('message',$message);
   }
   /*
    |--------------------------------------------------------------------------
    | Return From Fund Warehouse
    |--------------------------------------------------------------------------
    |*/
    public function returnFromFund(){
        $storeRooms = StoreRoom::where([
            ['receiver_id','=',1],
            ['in_out','=',4]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Main.returnFromFund',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | List of product (IN)
    |--------------------------------------------------------------------------
    |*/
    public function inStorage(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where([
                ['warehouse_id','=',1],
                ['in_out','=',1]
            ])->latest()->paginate(15);
            return view('Admin.StoreRoom.Main.inStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where([
                ['warehouse_id','=',2],
                ['in_out','=',6]
            ])->latest()->paginate(15);
            return view('Admin.StoreRoom.Fund.inStorage',compact('storeRooms'));
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
        $user = User::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>3])->latest()->paginate(10);
            return view('Admin.StoreRoom.Main.outStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['sender_id'=>2,'in_out'=>9])
            ->latest()->paginate(10);
            return view('Admin.StoreRoom.Fund.outStorage',compact('storeRooms'));
        }else{
            return abort(404);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | List of product (Mange Storage Change)
    |--------------------------------------------------------------------------
    |*/
    public function storageManage(){
        $user = User::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();
       
        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>2])->latest()->paginate(10);
            return view('Admin.StoreRoom.Main.storageChange',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>9])->latest()->paginate(10);
            return view('Admin.StoreRoom.Fund.storageChange',compact('storeRooms'));
        }else{
            return abort(404);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | List of product receive from main Warehouse
    |--------------------------------------------------------------------------
    |*/
    public function mainReceive(){
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>5])->latest()->paginate(10);
        return view('Admin.StoreRoom.Fund.mainReceive',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | accept receive product in fundwarehouse
    |--------------------------------------------------------------------------
    |*/
    public function acceptMainReceive($id){
        $storeRoom = StoreRoom::findOrFail($id); // this storeRoom
        $pre_id = $id - 1 ; // previous id for find previous storeRoom
        $pre_storeRoom = StoreRoom::findOrFail($pre_id); //previous storeRoom
        $status = 'App\Models\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['warehouse_id','=',$storeRoom->warehouse_id]
        ])->exists();
        /* IF product exist in fund warehouse */
        if($status == True){
            $storage = 'App\Models\Storage'::where([
                ['product_id','=',$storeRoom->product_id],
                ['warehouse_id','=',2]
            ])
            ->firstOrFail();
           
            $number = $storage->number + $storeRoom->number;
            $storage->update(['number'=>$number]);
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>6,
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['out_date'=>Carbon::now()]);// update out_date for previous storeRoom
            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد به موجودی انبار افزوده شد'; 
            return back()->with('message',$message);
        }else{
            $storage = 'App\Models\Storage'::create([
                'user_id'       =>  auth()->user()->id,
                'warehouse_id'  =>  2,
                'product_id'    =>  $storeRoom->product_id,
                'number'        =>  $storeRoom->number
            ]);
            
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>6,
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['out_date'=>Carbon::now()]);// update out_date for previous storeRoom
            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد برای اولین بار به انبار اضافه شد'; 
            return back()->with('message',$message);
        }

    }
    /*
    |--------------------------------------------------------------------------
    | send Product To Agent(Create Form)
    |--------------------------------------------------------------------------
    |*/
    public function AgentExchangesForm(){
        $products   =   Product::latest()->get();
        $transports =   Transport::latest()->get();
        $agents     =   User::role(['agent'])->get();
        return view('Admin.StoreRoom.Fund.AgentExchanges',compact('products','transports','agents'));
    }
    /*
    |--------------------------------------------------------------------------
    | send Product To Agent(store data)
    |--------------------------------------------------------------------------
    |*/
    public function sendToAgent(Request $request){
       
        $request->validate([
            'date'          =>  'required',
            'number'        =>  'required',
            'image'         =>  'required | mimes:jpeg,jpg,png,PNG | max:3000',
            'product'       =>  'required',
            'receiver'      =>  'required',
            'description'   =>  'required',
            'transport'     =>  'required',
            'status'        =>  'required',
            'pejak'         =>  'required | unique:store_rooms'

        ],[
            'date.required'             =>  'تاریخ را وارد کنید',
            'number.required'           =>  'تعداد کالا را وارد نکرده اید',
            'image.required'            =>  'تصویر بارنامه برای آپلود انتخاب نشده',
            'image.mimes'               =>  'فرمت مجاز برای تصویر بارنامه png و jpg است',
            'product.required'          =>  'محصول را انتخاب کنید',
            'receiver.required'         =>  'گیرنده را انتخاب کنید',
            'description.required'      =>  'توضیحاتی یادداشت نشده',
            'transport.required'        =>  'وسیله ارسالی را مشخص کنید',
            'status.required'           =>  'وضعیت را مشخص کنید',
            'pejak.unique'              =>  'این شماره بیجک قبلا در سیستم ثبت شده',
            'pejak.required'            =>  'شماره بیجک را وارد کنید'         
        ]);
       
        $storageStatus = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',2]
        ])->exists();
        
        if(!$storageStatus){
            $message = 'متاسفانه این محصول در انبار وجود ندارد';
            return redirect()->back()->with('info',$message);
        }
        
       
        $status = 'App\Models\Storage'::where([
            ['agent_id','=',$request->receiver],
            ['product_id','=',$request->product_id]
        ])->exists();
        /* IF this product number is not exist in fundwarehouse */
        $storage = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',2]
        ])->first();
       
        if($storage->number < $request->number){
            $message = ' این میزان موجودی در انبار وجود ندارد.موجودی این کالا  '.$storage->number.' عدد در انبار است';
            return redirect()->back()->with('info',$message);
        }
        $image = Storage::disk('public')->put('StoreRoom',$request->File('image'));
        /* IF this product is exist in agent storage */
        $date = Carbon::parse($request->date)->toDateString();
        if($status == True){
            /* update storage for this houseware  */
            $number = $storage->number - $request->number;
            $storage->update(['number'=>$number]);
            /* update storage for this agent  */
            $storage = 'App\Models\Storage'::where([
                ['receiver_id','=',$request->receiver],
                ['product_id','=',$request->product_id]
            ])->firstOrFail();
            $number = $storage->number + $request->number;
            $storage->update(['number'=>$number]);
            /* create storeRoom for fundWarehouse out */
           
            $storeRoom = StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'warehouse_id'      =>  2,
                'storage_id'        =>  $storage->id,
                'sender_id'         =>  2,
                'receiver_id'       =>  $request->receiver,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'image'             =>  $image,
                'in_out'            =>  7,
                'out_date'          =>  $date,
                'pejak'             =>  $request->pejak
            ]);
            /* create storeRoom for agent in */
            StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'storage_id'    =>  $storage->id,
                'sender_id'     =>  2,
                'receiver_id'   =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  10,
                'in_date'       =>  $date,
                'pejak'         =>  $request->pejak
            ]);
            $message = 'کالای '.$storeRoom->product->name.' به انبار نماینده افزوده شد ';
            return redirect()->route('storeRooms.index')->with('message',$message);
        }else{
            /* IF this product is not exist in agent storage */

            /* create storeRoom for fundWarehouse out */
            $storeRoom = StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'warehouse_id'  =>  2,
                'storage_id'    =>  $storage->id,
                'sender_id'     =>  2,
                'receiver_id'   =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  7,
                'out_date'      =>  $date,
                'pejak'         =>  $request->pejak
            ]);
            /* create storeRoom for agent in */
            StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'storage_id'    =>  $storage->id,
                'sender_id'     =>  2,
                'receiver_id'   =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  10,
                'in_date'       =>  $date,
                'pejak'         =>  $request->pejak
            ]);
            /* update storage for this houseware  */
            $number = $storage->number - $request->number;
            $storage->update(['number'=>$number]);
            $message = 'کالای '.$storeRoom->product->name.' به انبار نماینده افزوده شد ';
            return redirect()->route('storeRooms.index')->with('message',$message);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | send product from agent to agent
    |--------------------------------------------------------------------------
    |*/
    public function AgentToAgent(Request $request){
        $request->validate([
            'date'          =>  'required',
            'number'        =>  'required',
            'product'       =>  'required',
            'receiver'      =>  'required',
            'sender'        =>  'required',
            'description'   =>  'required',
            'transport'     =>  'required',
            'status'        =>  'required'

        ],[
            'date.required'             =>  'تاریخ را وارد کنید',
            'number.required'           =>  'تعداد کالا را وارد نکرده اید',
            'product.required'          =>  'محصول را انتخاب کنید',
            'receiver.required'         =>  'گیرنده را انتخاب کنید',
            'sender.required'           =>  'ارسال کننده را مشخص کنید',
            'description.required'      =>  'توضیحاتی یادداشت نشده',
            'transport.required'        =>  'وسیله ارسالی را مشخص کنید',
            'status.required'           =>  'وضعیت را مشخص کنید'
        ]);
        /* Check Agent warehouse for this product  */
        $status = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$request->sender]
        ])->exists();
        
        $sender_storage = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$request->sender]
        ])->first();
       
        $agent = User::findOrFail($request->sender);
       
        $date = Carbon::parse($request->date)->toDateString();
        if($status == True){
            /* IF storage number less than request number */
            if($sender_storage->number < $request->number){
                $message = ' این میزان موجودی در انبار وجود ندارد  '.$agent->name.' '.$agent->family;
                $message .= ' در انبار این نماینده '.' '.$sender_storage->number.' عدد از این محصول وجود دارد ';
                return back()->with('info',$message);
            }
       
            /* Check Agent warehouse for this product  */
            $receiver_status = 'App\Models\Storage'::where([
                ['product_id','=',$request->product],
                ['agent_id','=',$request->receiver]
            ])->exists();
            $number = $sender_storage->number - $request->number;
            $sender_storage->update(['number'=>$number]);
            
            // create store room for fundWareHouse
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'warehouse_id'      =>  2,
                'storage_id'        =>  $sender_storage->id,
                'receiver_id'       =>  $request->receiver,
                'sender_id'         =>  $request->sender,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  8,
                'out_date'          =>  $date
            ]);
            // create store room for receiver agent
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $sender_storage->id,
                'receiver_id'       =>  $request->receiver,
                'sender_id'         =>  $request->sender,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  10,
                'out_date'          =>  $date
            ]);
            // create store room for sender_id agent
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $sender_storage->id,
                'receiver_id'       =>  $request->receiver,
                'sender_id'         =>  $request->sender,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  12,
                'out_date'          =>  $date
            ]);
            
            
            return redirect()->route('storeRooms.index')->with('message','کالا به انبار نماینده ارسال شد');
                
        }else{
            $message = "در انبار نماینده ارسال کننده این کالا ثبت نشده";
            return back()->with('info',$message);
        }


    }
    
    /*
    |--------------------------------------------------------------------------
    | Return Product To Main WareHouse Storage
    |--------------------------------------------------------------------------
    |*/
    public function returnToMain(Request $request){
        $status = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',2]
        ])->exists();

        if($status == false){
            return back()->with('info','این کالا در انبار موجود نیست');
        }
       
        $fundWarestorage = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',2]
        ])->first();
        $mainWarestorage = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',1]
        ])->first();
        $date = Carbon::parse($request->date)->toDateString();
        if($fundWarestorage->number > $request->number){
            
            // create store room for fundWareHouse
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $fundWarestorage->id,
                'receiver_id'       =>  1,
                'sender_id'         =>  2,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  9,
                'out_date'          =>  $date
            ]);
            // create store room for mainWareHouse
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $fundWarestorage->id,
                'receiver_id'       =>  1,
                'sender_id'         =>  2,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  15,
                'out_date'          =>  $date
            ]);
            // FundWareHouse Storage 
            $numberInFundHouse = $fundWarestorage->number - $request->number;
            $fundWarestorage->update(['number'=>$numberInFundHouse]);
            // MainWareHouse Storage
            // $numberInMainHouse = $mainWarestorage->number + $request->number;
            // $mainWarestorage->update(['number'=>$numberInMainHouse]);
            $message = 'این کالا به انبار مادر برگشت داده شد';
            return back()->with('message',$message);
    
        }else{
            $message = ' این میزان موجودی در انبار تنخواه موجود نیست  ';
            $message .= ' در انبار این '.$fundWarestorage->number.' عدد از این محصول وجود دارد ';
            return back()->with('message',$message);
        }   
    }
    /*
    |--------------------------------------------------------------------------
    | Accept From Fund Form
    |--------------------------------------------------------------------------
    |*/
    public function acceptFromFundForm(){
        $storeRooms = StoreRoom::where(['in_out'=>15])->latest()->paginate(15);
        return view('Admin.StoreRoom.Main.returnFromFundNotConfirm',compact('storeRooms'));
    }

    public function acceptFromFund(Request $request,$id){
        $pre_id = $id -1;
        $storeRoom      = StoreRoom::findOrFail($id);
        $pre_storeRoom = StoreRoom::findOrFail($pre_id); 
        $mainWarestorage = 'App\Models\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['warehouse_id','=',1]
        ])->first();
     
        $numberInMainHouse = $mainWarestorage->number + $storeRoom->number;
        $mainWarestorage->update(['number'=>$numberInMainHouse]);
        $storeRoom->update(['in_out'=>4,'in_date'=>Carbon::now()]);
        $pre_storeRoom->update(['in_date'=>Carbon::now()]);    
        return back()->with('message','به لیست مرجوعی از انبار تنخواه اضافه شد.موجودی محصول افزایش یافت');
    }
    /*
    |--------------------------------------------------------------------------
    | Return To Fund Form Page
    |--------------------------------------------------------------------------
    |*/
    public function returnToFundForm(){
        $user = User::findOrFail(auth()->user()->id);
        $storages = 'App\Models\Storage'::Where([
            ['agent_id','=',$user->id],
            ['number','>',0]
        ])->get();
        
        return view('Admin.StoreRoom.Agent.returnToFund',compact('storages'));
    }
    /*
    |--------------------------------------------------------------------------
    | Return Product To Fund WareHouse Storage
    |--------------------------------------------------------------------------
    |*/
    public function returnToFund(Request $request){
        $id = auth()->user()->id;
        $user = User::findOrFail($id);

        if($user->backToWareHouse == null){
            return back()->with('info','دسترسی شما برای برگشت کالا توسط ادمین محدود شده است');
        }
        $status = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$id]
        ])->exists();

        if($status == false){
            return back()->with('info','این کالا در انبار شما موجود نیست');
        }
       
        $AgentStorage = 'App\Models\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$id]
        ])->first();
        $date = Carbon::parse($request->date)->toDateString();
        if($AgentStorage->number > $request->number){
            
            // create store room for AgentStorage
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $AgentStorage->id,
                'receiver_id'       =>  2,
                'sender_id'         =>  $id,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'in_out'            =>  12,
                'out_date'          =>  $date
            ]);
            $FundWareStorage = 'App\Models\Storage'::where([
                ['product_id','=',$request->product],
                ['warehouse_id','=',2]
            ])->firstOrFail();
            // create store room for FundWareStorage
            StoreRoom::create([
                'user_id'               =>  auth()->user()->id,
                'storage_id'            =>  $FundWareStorage->id,
                'receiver_id'           =>  2,
                'sender_id'             =>  $id,
                'product_id'            =>  $request->product,
                'transport_id'          =>  $request->transport,
                'number'                =>  $request->number,
                'description'           =>  $request->description,
                'status'                =>  $request->status,
                'in_out'                =>  16,
                'out_date'              =>  $date
            ]);
            // AgentWareHouse Storage 
            $numberInAgent = $AgentStorage->number - $request->number;
            $AgentStorage->update(['number'=>$numberInAgent]);
            
            $message = 'این کالا به انبار تنخواه برگشت داده شد';
            return back()->with('message',$message);
    
        }else{
            $message = ' این میزان موجودی در انبار شما موجود نیست  ';
            $message .= ' در انبار شما '.$fundWarestorage->number.' عدد از این محصول وجود دارد ';
            return back()->with('message',$message);
        }  
    }
    /*
    |--------------------------------------------------------------------------
    | Return From Agent Page
    |--------------------------------------------------------------------------
    |*/
    public function ReturnFromAgentPage(){
        $storeRooms = StoreRoom::where([
            ['receiver_id','=',2],
            ['in_out','=',16]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Fund.returnFromAgentOnConfirm',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Accept Agent Returned Products
    |--------------------------------------------------------------------------
    |*/
    public function AcceptAgentReturnedProducts($id){

        $pre_id = $id - 1;
        $storeRoom      = StoreRoom::findOrFail($id);
        $pre_storeRoom  = StoreRoom::findOrFail($pre_id);

        $storeRoom->update(['in_date'=>Carbon::now(),'in_out'=>13]);
        $pre_storeRoom->update(['in_date'=>Carbon::now()]);
        $FundWareStorage = 'App\Models\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['warehouse_id','=',2]
        ])->firstOrFail();
        // FundWareHouse Storage
        $numberInFundWare = $FundWareStorage->number + $storeRoom->number;
        $FundWareStorage->update(['number'=>$numberInFundWare]);
       
        return back()->with('message','کالای برگشتی از سمت نماینده با موفقیت تایید شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Display list of product send to agents
    |--------------------------------------------------------------------------
    |*/
    public function SendToAgentList(){
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>7])->latest()->paginate(1000);
        return view('Admin.StoreRoom.Fund.SendToAgentList',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Return From Agents warehouse
    |--------------------------------------------------------------------------
    |*/
    public function returnFromAgents(){
        $storeRooms = StoreRoom::where([
            ['receiver_id','=',2],
            ['in_out','=',13]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Fund.returnFromAgents',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Exchange Storage Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentExchangeStorage(){
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>8])->latest()->paginate(1000);
        return view('Admin.StoreRoom.Fund.AgentExchangeStorage',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Fund Receive Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentReceive(){
        $user = User::findOrFail(auth()->user()->id);
        $storeRooms = StoreRoom::where(['receiver_id'=>$user->id,'in_out'=>10])->latest()->paginate(10);
        return view('Admin.StoreRoom.Agent.AgentReceive',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Accept Fund Receive
    |--------------------------------------------------------------------------
    |*/
    public function acceptFundReceive(Request $request,$id){
       
        $user = User::findOrFail(auth()->user()->id);
        $storeRoom = StoreRoom::findOrFail($id); // this storeRoom
        $pre_id = $id - 1 ; // previous id for find previous storeRoom
        $pre_storeRoom = StoreRoom::findOrFail($pre_id); //previous storeRoom
        $status = 'App\Models\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['agent_id','=',$user->id]
        ])->exists();
        
        /* IF product exist in fund warehouse */
        if($status == True){
            $storage = 'App\Models\Storage'::where([
                ['product_id','=',$storeRoom->product_id],
                ['agent_id','=',$user->id]
            ])
            ->firstOrFail();
           
            $number = $storage->number + $storeRoom->number;
            $storage->update(['number'=>$number]);
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>11,
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['in_date'=>Carbon::now()]);// update out_date for previous storeRoom
            
            if($storeRoom->sender_id != 2){
                $next_id = $id + 1;
                $next_storeRoom = StoreRoom::findOrFail($next_id); //Next storeRoom
                $next_storeRoom->update(['in_date'=>Carbon::now()]);
            }

            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد به موجودی انبار افزوده شد'; 
            return back()->with('message',$message);
        }else{
           
            $storage = 'App\Models\Storage'::create([
                'user_id'       =>  auth()->user()->id,
                'agent_id'      =>  $user->id,
                'product_id'    =>  $storeRoom->product_id,
                'number'        =>  $storeRoom->number
            ]);
            
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>11,
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['in_date'=>Carbon::now()]);// update out_date for previous storeRoom
            
            if($storeRoom->sender_id != 2){
                $next_id = $id + 1;
                $next_storeRoom = StoreRoom::findOrFail($next_id); //Next storeRoom
                $next_storeRoom->update(['in_date'=>Carbon::now()]);
            }

            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد برای اولین بار به انبار اضافه شد'; 
            return back()->with('message',$message);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Index Warehouse
    |--------------------------------------------------------------------------
    |*/
    public function AgentIndexWarehouse(){
        $user = User::findOrFail(auth()->user()->id);
        $storages = 'App\Models\Storage'::where('agent_id',$user->id)->latest()->paginate(10);
        $allProduct = 'App\Models\Storage'::where('agent_id',$user->id)->sum('number');
        return view('Admin.StoreRoom.Agent.index',compact('storages','allProduct'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Out List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOut(){
        $id = auth()->user()->id;
        $storeRooms = StoreRoom::where([
            ['sender_id','=',$id],
            ['in_out','=',12]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Agent.AgentOut',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent In List
    |--------------------------------------------------------------------------
    |*/
    public function AgentIn(){
        $id = auth()->user()->id;
        $storeRooms = StoreRoom::where([
            ['receiver_id','=',$id],
            ['in_out','=',11]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Agent.AgentIn',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Delivery To Customers List
    |--------------------------------------------------------------------------
    |*/
    public function DeliveryToCustomersList(){
        $id = auth()->user()->id;
        $storeRooms = StoreRoom::where([
            ['sender_id','=',$id],
            ['in_out','=',14]
        ])->latest()->paginate(15);
        
        return view('Admin.StoreRoom.Agent.delivery-to-customers',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agents List For Check Storage
    |--------------------------------------------------------------------------
    |*/
    public function AgentsListForCheckStorage(){

        $user = User::findOrFail(auth()->user()->id);

        $agents = User::where('agent_id',$user->id)->Role('agent')->latest()->paginate(15);
        
        return view('Admin.StoreRoom.AgentChief.check-agents-storage-list',compact('agents'));
    
    }
    /*
    |--------------------------------------------------------------------------
    | Agens Storage WareHoouse
    |--------------------------------------------------------------------------
    |*/
    public function AgensStorageWareHoouse($agent_id){

        $user = User::findOrFail(auth()->user()->id);

        $agent = User::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(404);
        }

        $storages = 'App\Models\Storage'::where('agent_id',$agent_id)->latest()->get();
        $allProduct = 'App\Models\Storage'::where('agent_id',$agent_id)->sum('number');
        return view('Admin.StoreRoom.AgentChief.agents-storage',compact('storages','allProduct', 'user'));
    }
    /*
    |--------------------------------------------------------------------------
    |  Agens Storage In
    |--------------------------------------------------------------------------
    |*/
    public function AgensStorageIn($agent_id){
        $user = User::findOrFail(auth()->user()->id);

        $agent = User::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(404);
        }
        $storeRooms = StoreRoom::where([
            ['receiver_id','=',$agent_id],
            ['in_out','=',11]
        ])->latest()->paginate(15);
        return view('Admin.StoreRoom.Agent.AgentIn',compact('storeRooms'));
    }

    /*
    |--------------------------------------------------------------------------
    | Agens Storage Out
    |--------------------------------------------------------------------------
    |*/
    public function AgensStorageOut($agent_id){

        $user = User::findOrFail(auth()->user()->id);

        $agent = User::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(403);
        }
        $storeRooms = StoreRoom::where([
            ['sender_id','=',$agent_id],
            ['in_out','=',12]
        ])
        ->latest()->paginate(15);
        return view('Admin.StoreRoom.Agent.AgentOut',compact('storeRooms'));
    }
    
    /*
    |--------------------------------------------------------------------------
    | Agens Delivery To Customers
    |--------------------------------------------------------------------------
    |*/
    public function AgensDeliveryToCustomers($agent_id){
       
        $user = User::findOrFail(auth()->user()->id);

        $agent = User::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(403);
        }

        $storeRooms = StoreRoom::where([
            ['sender_id','=',$agent_id],
            ['in_out','=',14]
        ])->latest()->paginate(15);
        
        return view('Admin.StoreRoom.Agent.delivery-to-customers',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Destroy Row from store_rooms table
    |--------------------------------------------------------------------------
    |*/
    public function delete($id){
        
        $storeRoom = StoreRoom::findOrFail($id);

        /** Agent To Agent with FundHouseWare */
        if($storeRoom->in_out == 8 && is_null($storeRoom->in_date) ){
            
            return $this->AgentToAgentDelete($storeRoom,$id);

        /** Agent In OnConfirm */
        }elseif($storeRoom->in_out == 12 && is_null($storeRoom->in_date) ){
            
            $pre_id = $id - 1;
            $pre_id2 = $id - 2;
            $pre2_storeRoom = StoreRoom::find($pre_id2);

            if(is_null($pre2_storeRoom)){

                return $this->NormalDelete($storeRoom,$id);

            }elseif($pre2_storeRoom->in_out == 8){
                $pre_storeRoom = StoreRoom::findOrFail($pre_id);
                $pre2_storeRoom = StoreRoom::findOrFail($pre_id2);
                /** storage */
                $storage = 'App\Models\Storage'::findOrFail($storeRoom->storage_id);
                $number = $storage->number + $storeRoom->number;
                $storage->update(['number'=>$number]);
                $pre_storeRoom->delete();
                $pre2_storeRoom->delete();
                $storeRoom->delete();

                return back()->with('message','با موفقیت حدف شد و موجودی به انبار بازگشت داده شد');
                
            }else{

                return $this->NormalDelete($storeRoom,$id);

            }
            
        /** send To Agent */
        }elseif($storeRoom->in_out == 7 && is_null($storeRoom->in_date) ){

            return $this->NormalDelete($storeRoom,$id);

        /** send To FundHouseWare */
        }elseif($storeRoom->in_out == 2 && is_null($storeRoom->out_date)){
            
            return $this->NormalDelete($storeRoom,$id);

        /** return To MainHouseWare */
        }elseif($storeRoom->in_out == 9 && is_null($storeRoom->in_date)){

            return $this->NormalDelete($storeRoom,$id);

        }else{
            return back()->with('info','متاسفانه دیر اقدام کردید این قابلیت از کار افتاده است');
        }

        
    }
    /*
    |--------------------------------------------------------------------------
    | Normal Delete
    |--------------------------------------------------------------------------
    |*/
    public function NormalDelete($storeRoom,$id){
        $storage = 'App\Models\Storage'::findOrFail($storeRoom->storage_id);
        $number = $storage->number + $storeRoom->number;
        $storage->update(['number'=>$number]);
        $next_id = $id + 1;
        $next_storeRoom = StoreRoom::findOrFail($next_id);
        /** delete store room */
        $storeRoom->delete();
        /** delete next store room */
        $next_storeRoom->delete();
        return back()->with('message','با موفقیت حذف شد و موجودی به انبار بازگشت داده شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent To Agent Delete
    |--------------------------------------------------------------------------
    |*/
    public function AgentToAgentDelete($storeRoom,$id){
        $next_id    = $id + 1;
        $next_id2   = $id + 2;
        $next_storeRoom = StoreRoom::findOrFail($next_id);
        $next2_storeRoom = StoreRoom::findOrFail($next_id2);
        /** delete store room */
        $storeRoom->delete();
        /** delete next store room */
        $next_storeRoom->delete();
        /** delete next 2 store room */
        $next2_storeRoom->delete();
        $storage = 'App\Models\Storage'::findOrFail($next2_storeRoom->storage_id);
        $number = $storage->number + $storeRoom->number;
        $storage->update(['number'=>$number]);
        return back()->with('message','با موفقیت حدف شد و موجودی به انبار نماینده بازگشت داده شد');
    }
    /*
    |--------------------------------------------------------------------------
    | store Rooms Update
    |--------------------------------------------------------------------------
    |*/
    public function storeRoomsUpdate(Request $request,$id){
        $storeRoom = StoreRoom::findOrFail($id);
        
        if($storeRoom->in_out == 8 && is_null($storeRoom->in_date) ){
            
            return $this->AgentToAgentFund($storeRoom,$id,$request);

        /** Agent In OnConfirm */
        }elseif($storeRoom->in_out == 12 && is_null($storeRoom->in_date) ){
            
            $pre_id = $id - 1;
            $pre_id2 = $id - 2;
            $pre2_storeRoom = StoreRoom::find($pre_id2);

            if(is_null($pre2_storeRoom)){

                return $this->NormalUpdate($storeRoom,$id,$request);

            }elseif($pre2_storeRoom->in_out == 8){

                return $this->AgentToAgentOut($storeRoom,$id,$request,$pre_id,$pre_id2);
                
            }else{

                return $this->NormalUpdate($storeRoom,$id,$request);

            }
            
        /** send To Agent */
        }elseif($storeRoom->in_out == 7 && is_null($storeRoom->in_date) ){

            return $this->NormalUpdate($storeRoom,$id,$request);

        /** send To FundHouseWare */
        }elseif($storeRoom->in_out == 2 && is_null($storeRoom->out_date)){
            
            return $this->NormalUpdate($storeRoom,$id,$request);

        /** return To MainHouseWare */
        }elseif($storeRoom->in_out == 9 && is_null($storeRoom->in_date)){

            return $this->NormalUpdate($storeRoom,$id,$request);

        }else{
            return back()->with('info','متاسفانه دیر اقدام کردید این قابلیت از کار افتاده است');
        }
    }
    /*
    |--------------------------------------------------------------------------
    | store Rooms Normal Update
    |--------------------------------------------------------------------------
    |*/
    public function NormalUpdate($storeRoom,$id,$request){
        $storage = 'App\Models\Storage'::findOrFail($storeRoom->storage_id);

        
        $cal = $storage->number + $storeRoom->number;
        if($cal < $request->number){
            return back()->with('info','این تعداد کالا از این محصول در انبار وجود ندارد');
        }

        if($storeRoom->number > $request->number){
            $number = $storeRoom->number - $request->number;
            $number = $storage->number + $number;

        }elseif($storeRoom->number < $request->number){
            $number = $request->number - $storeRoom->number ;
            $number = $storage->number - $number;

        }else{
            $number = $storage->number;
        }

        $next_id = $id + 1;
        $next_storeRoom = StoreRoom::findOrFail($next_id);
        /** update store room */
        $storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        /** update next store room */
        $next_storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        $storage->update([
            'number'=>$number]);
        

        return back()->with('message','موجودی انبار به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | store Rooms Agent To Agent Update-Agent
    |--------------------------------------------------------------------------
    |*/
    public function AgentToAgentOut($storeRoom,$id,$request,$pre_id,$pre_id2){
        $storage = 'App\Models\Storage'::findOrFail($storeRoom->storage_id);
       
        $pre_storeRoom = StoreRoom::findOrFail($pre_id);
       
        $pre2_storeRoom = StoreRoom::findOrFail($pre_id2);
        
        
        $cal = $storage->number + $storeRoom->number;
        if($cal < $request->number){
            return back()->with('info','این تعداد کالا از این محصول در انبار وجود ندارد');
        }

        if($storeRoom->number > $request->number){
            $number = $storeRoom->number - $request->number;
            $number = $storage->number + $number;

        }elseif($storeRoom->number < $request->number){
            $number = $request->number - $storeRoom->number ;
            $number = $storage->number - $number;

        }else{
            $number = $storage->number;
        }

        $storeRoom = StoreRoom::findOrFail($id);
        /** update store room */
        $storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        /** update pre store room */
        $pre_storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        /** update pre 2 store room */
        $pre2_storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        $storage->update([
            'number'=>$number]);
        

        return back()->with('message','موجودی انبار به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | store Rooms Agent To Agent Update-Fund
    |--------------------------------------------------------------------------
    |*/
    public function AgentToAgentFund($storeRoom,$id,$request){
        
        $next_id    = $id + 1;
        $next_id2   = $id + 2;
       
        $next_storeRoom     = StoreRoom::findOrFail($next_id);
        $next2_storeRoom    = StoreRoom::findOrFail($next_id2);
        $storage = 'App\Models\Storage'::findOrFail($next2_storeRoom->storage_id);
        $cal = $storage->number + $storeRoom->number;
        if($cal < $request->number){
            return back()->with('info','این تعداد کالا از این محصول در انبار وجود ندارد');
        }

        if($storeRoom->number > $request->number){
            $number = $storeRoom->number - $request->number;
            $number = $storage->number + $number;

        }elseif($storeRoom->number < $request->number){
            $number = $request->number - $storeRoom->number ;
            $number = $storage->number - $number;

        }else{
            $number = $storage->number;
        }

        $next_id = $id + 1;
        $next_storeRoom = StoreRoom::findOrFail($next_id);
        /** update store room */
        $storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        /** update next store room */
        $next_storeRoom->update([
            'number'=>$request->number,
            'description'=>$request->desc
            ]);
        $storage->update([
            'number'=>$number]);
        

        return back()->with('message','موجودی انبار به روز رسانی شد');
    }


}
