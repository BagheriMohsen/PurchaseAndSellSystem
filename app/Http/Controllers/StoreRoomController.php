<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\StoreRoom;
use Carbon\Carbon;
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
            $storages = 'App\Storage'::where('warehouse_id',1)->paginate();
            $allProduct = 'App\Storage'::where('warehouse_id',1)->sum('number');
            
            
        }else{
            $storages = 'App\Storage'::where('warehouse_id',2)->paginate();
            $allProduct = 'App\Storage'::where('warehouse_id',2)->sum('number');
           
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
        $products = 'App\Product'::latest()->get();
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

        $status = 'App\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',1]
        ])->exists();
        
            /*(IN) IF product is exist in storage table*/
            if($status == true){
                $storage = 'App\Storage'::where([
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
                    'in_out'        =>  $request->in_out
                ]);
            }else{
                /*IF product is not exist in storage table*/
                $storage = 'App\Storage'::create([
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
                    'in_out'        =>  $request->in_out
                ]);

            }

            $product = 'App\Product'::findOrFail($request->product);
           
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

            $status = 'App\Storage'::where([
                ['product_id','=',$request->product],
                ['warehouse_id','=',1]
            ])->exists();
            /*(OUT) IF product is exist in storage table */
            if($status == true && $request->in_out == "out"){
                
                $storage = 'App\Storage'::where([
                    ['product_id','=',$request->product],
                    ['warehouse_id','=',1]
                ])->firstOrFail();

                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  1,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'in_out'        =>  $request->in_out
                ]);

            if($storage->number >= $request->number){
                $number = $storage->number - $request->number;
                $storage->update(['number'=>$number]);
            }else{
                $message = " این تعداد ".$storage->product->name." در انبار موجود نیست"." از این کالا در انبار".$storage->number." عدد وجود دارد";
                return back()->with('info',$message);
            }
        }else{
            return back()->with('info','این کالا در انبار موجود نیست');
        }


        $product = 'App\Product'::findOrFail($request->product);
            
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

        $status = 'App\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',1]
        ])->exists();
         /*(ANBAR) IF product is exist in storage table*/
        if($status == true){
            $storage = 'App\Storage'::where([
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
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'in_out'        =>  $request->in_out
                ]);
                // fundWarehouse
                StoreRoom::create([
                    'user_id'       =>  auth()->user()->id,
                    'warehouse_id'  =>  2,
                    'storage_id'    =>  $storage->id,
                    'product_id'    =>  $request->product,
                    'number'        =>  $request->number,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'in_out'        =>  $request->in_out
                ]);

            }else{
                $message = " این تعداد ".$storage->product->name." در انبار موجود نیست "." از این کالا در انبار ".$storage->number." عدد وجود دارد";
                return back()->with('info',$message);
            }
        }else{
            return back()->with('info','این کالا در انبار موجود نیست');
        }
        $product = 'App\Product'::findOrFail($request->product);
            
        $message = 'محصول '.$product->name.' به تعداد  '.$request->number.' عدد به انبار تنخواه منتقل شد ';
        
        return redirect()->route('storeRooms.index')->with('message',$message);
   }
    /*
    |--------------------------------------------------------------------------
    | List of product (IN)
    |--------------------------------------------------------------------------
    |*/
    public function inStorage(Request $request){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>'in'])->latest()->paginate(10);
            return view('Admin.StoreRoom.Main.inStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'Received'])->latest()->paginate(10);
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
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();

        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>'out'])->latest()->paginate(10);
            return view('Admin.StoreRoom.Main.outStorage',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>['out','sendToAgent']])
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
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $role = $user->getRoleNames()->first();
       
        if($role == "mainWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>1,'in_out'=>'sendToFund'])->latest()->paginate(10);
            return view('Admin.StoreRoom.Main.storageChange',compact('storeRooms'));
        }elseif($role == "fundWarehouser"){
            $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'backToMain'])->latest()->paginate(10);
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
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'sendToFund'])->latest()->paginate(10);
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
        $status = 'App\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['warehouse_id','=',$storeRoom->warehouse_id]
        ])->exists();
        /* IF product exist in fund warehouse */
        if($status == True){
            $storage = 'App\Storage'::where([
                ['product_id','=',$storeRoom->product_id],
                ['warehouse_id','=',2]
            ])
            ->firstOrFail();
           
            $number = $storage->number + $storeRoom->number;
            $storage->update(['number'=>$number]);
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>'Received',
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['out_date'=>Carbon::now()]);// update out_date for previous storeRoom
            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد به موجودی انبار افزوده شد'; 
            return back()->with('message',$message);
        }else{
            $storage = 'App\Storage'::create([
                'user_id'       =>  auth()->user()->id,
                'warehouse_id'  =>  2,
                'product_id'    =>  $storeRoom->product_id,
                'number'        =>  $storeRoom->number
            ]);
            
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>'Received',
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
        $products   = 'App\Product'::latest()->get();
        $transports = 'App\Transport'::latest()->get();
        $agents     =  'App\User'::role(['agent','agentChief'])->get();
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
            'status'        =>  'required'

        ],[
            'date.required'             =>  'تاریخ را وارد کنید',
            'number.required'           =>  'تعداد کالا را وارد نکرده اید',
            'image.required'            =>  'تصویر بارنامه برای آپلود انتخاب نشده',
            'image.mimes'               =>  'فرمت مجاز برای تصویر بارنامه png و jpg است',
            'product.required'          =>  'محصول را انتخاب کنید',
            'receiver.required'         =>  'گیرنده را انتخاب کنید',
            'description.required'      =>  'توضیحاتی یادداشت نشده',
            'transport.required'        =>  'وسیله ارسالی را مشخص کنید',
            'status.required'           =>  'وضعیت را مشخص کنید'
        ]);
       
        $image = Storage::disk('public')->put('StoreRoom',$request->File('image'));
        $status = 'App\Storage'::where([
            ['agent_id','=',$request->receiver],
            ['product_id','=',$request->product_id]
        ])->exists();
        /* IF this product number is not exist in fundwarehouse */
        $storage = 'App\Storage'::where([
            ['product_id','=',$request->product],
            ['warehouse_id','=',2]
        ])->first();

        if($storage->number < $request->number){
            $message = ' این میزان موجودی در انبار وجود ندارد.موجودی این کالا  '.$storage->number.' عدد در انبار است';
            return redirect()->back()->with('info',$message);
        }
        /* IF this product is exist in agent storage */
        if($status == True){
            /* update storage for this houseware  */
            $number = $storage->number - $request->number;
            $storage->update(['number'=>$number]);
            /* update storage for this agent  */
            $storage = 'App\Storage'::where([
                ['rcv_agent_id','=',$request->receiver],
                ['product_id','=',$request->product_id]
            ])->firstOrFail();
            $number = $storage->number + $request->number;
            $storage->update(['number'=>$number]);
            /* create storeRoom for fundWarehouse out */
            $storeRoom = StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'warehouse_id'  =>  2,
                'storage_id'    =>  $storage->id,
                'rcv_agent_id'  =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  $request->in_out,
                'in_date'       =>  $request->date
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
                'rcv_agent_id'  =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  $request->in_out
            ]);
            /* create storeRoom for agent in */
            StoreRoom::create([
                'user_id'       =>  auth()->user()->id,
                'storage_id'    =>  $storage->id,
                'rcv_agent_id'  =>  $request->receiver,
                'product_id'    =>  $request->product,
                'transport_id'  =>  $request->transport,
                'number'        =>  $request->number,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'image'         =>  $image,
                'in_out'        =>  $request->in_out,
                'in_date'       =>  $request->date
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
        $status = 'App\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$request->sender]
        ])->exists();
        
        $sender_storage = 'App\Storage'::where([
            ['product_id','=',$request->product],
            ['agent_id','=',$request->sender]
        ])->first();
       
        $agent = 'App\User'::findOrFail($request->sender);
        
        
        if($status == True){
            /* IF storage number less than request number */
            if($sender_storage->number < $request->number){
                $message = ' این میزان موجودی در انبار  '.$agent->name.' '.$agent->family;
                $message .= ' با نام کاربری '.$agent->username.' وجود ندارد';
                $message .='</br>';
                $message .= ' در انبار این نماینده '. $agent->username.' '.$sender_storage->number.' عدد از این محصول وجود دارد ';
                return back()->with('info',$message);
            }
            /* Check Agent warehouse for this product  */
            $receiver_status = 'App\Storage'::where([
                ['product_id','=',$request->product],
                ['agent_id','=',$request->receiver]
            ])->exists();
            $number = $sender_storage->number - $request->number;
            $sender_storage->update(['number'=>$number]);
            StoreRoom::create([
                'user_id'           =>  auth()->user()->id,
                'storage_id'        =>  $sender_storage->id,
                'rcv_agent_id'      =>  $request->receiver,
                'sender_agent_id'   =>  $request->sender_agent_id,
                'product_id'        =>  $request->product,
                'transport_id'      =>  $request->transport,
                'number'            =>  $request->number,
                'description'       =>  $request->description,
                'status'            =>  $request->status,
                'image'             =>  $image,
                'in_out'            =>  $request->in_out,
                'out_date'          =>  $request->date
            ]);
            
            return redirect()->route('storeRooms.index')->with('message','کالا به انبار نماینده ارسال شد');
                
        }else{
            $message = "در انبار نماینده ارسال کننده این کالا ثبت نشده";
            return back()->with('info',$message);
        }


    }
    /*
    |--------------------------------------------------------------------------
    | Display list of product send to agents
    |--------------------------------------------------------------------------
    |*/
    public function SendToAgentList(){
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'sendToAgent'])->latest()->paginate(10);
        return view('Admin.StoreRoom.Fund.outStorage',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Exchange Storage Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentExchangeStorage(){
        $storeRooms = StoreRoom::where(['warehouse_id'=>2,'in_out'=>'AgentToAgent'])->latest()->paginate(10);
        return view('Admin.StoreRoom.Fund.AgentExchangeStorage',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Fund Receive Page
    |--------------------------------------------------------------------------
    |*/
    public function FundReceive(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $storeRooms = StoreRoom::where(['rcv_agent_id'=>$user->id,'in_out'=>'sendToAgent'])->latest()->paginate(10);
        return view('Admin.StoreRoom.Agent.fundReceive',compact('storeRooms'));
    }
    /*
    |--------------------------------------------------------------------------
    | Accept Fund Receive
    |--------------------------------------------------------------------------
    |*/
    public function acceptFundReceive($id){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $storeRoom = StoreRoom::findOrFail($id); // this storeRoom
        $pre_id = $id - 1 ; // previous id for find previous storeRoom
        $pre_storeRoom = StoreRoom::findOrFail($pre_id); //previous storeRoom
        $status = 'App\Storage'::where([
            ['product_id','=',$storeRoom->product_id],
            ['agent_id','=',$user->id]
        ])->exists();
        
        /* IF product exist in fund warehouse */
        if($status == True){
            $storage = 'App\Storage'::where([
                ['product_id','=',$storeRoom->product_id],
                ['agent_id','=',$user->id]
            ])
            ->firstOrFail();
           
            $number = $storage->number + $storeRoom->number;
            $storage->update(['number'=>$number]);
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>'Received',
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['out_date'=>Carbon::now()]);// update out_date for previous storeRoom
            $message = 'کالای '.$storeRoom->product->name.' به تعداد '.$storeRoom->number.' عدد به موجودی انبار افزوده شد'; 
            return back()->with('message',$message);
        }else{
            $storage = 'App\Storage'::create([
                'user_id'       =>  auth()->user()->id,
                'agent_id'      =>  $user->id,
                'product_id'    =>  $storeRoom->product_id,
                'number'        =>  $storeRoom->number
            ]);
            
            $storeRoom->update([
                'storage_id'=>$storage->id,
                'in_out'=>'Received',
                'in_date'=> Carbon::now()
                ]);//update in_date and apply this product fot funWarehouse
            $pre_storeRoom->update(['out_date'=>Carbon::now()]);// update out_date for previous storeRoom
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
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $storages = 'App\Storage'::where('agent_id',$user->id)->latest()->paginate(10);
        $allProduct = 'App\Storage'::where('agent_id',$user->id)->sum('number');
        return view('Admin.StoreRoom.Agent.index',compact('storages','allProduct'));
    }

}
