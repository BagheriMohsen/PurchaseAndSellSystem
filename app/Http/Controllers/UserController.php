<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


use App\Models\User;
use App\Models\Order;
use App\Models\State;
use App\Models\City;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\PaymentCirculation;
use App\Models\UserInventory;
use App\Models\MoneyCirculation;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::Role([
            'normalUser',
            'admin',
            'agentChief',
            'followUpManager',
            'mainWarehouser',
            'fundWarehouser'
            ])->get();
        return view('Admin.User.users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agentChiefs  = User::Role('agentChief')->get();
        $roles = Role::where([
            ['id','!=',1],
            ['id','!=',7],
            ['id','!=',8]
        ])->get();
        
        $cities         =   City::latest()->get();
        $states         =   State::latest()->get();
        $agentChiefs    =   User::Role('agentChief')->get();
        $callCenters    =   User::Role('callCenter')->get();
        return view('Admin.User.users-create',compact(
            'cities',
            'states',
            'roles',
            'agentChiefs',
            'callCenters'
        ));
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
            'username'  =>  'unique:users'
        ],[
            'username.unique'  =>  'این نام کاربری قبلا استفاده شده'
        ]);
         $user = User::create([
            'name'                  =>  $request->name,
            'family'                =>  $request->family,
            'sex'                   =>  $request->sex,
            'username'              =>  $request->username,
            'password'              =>  Hash::make($request->password),
            'mobile'                =>  $request->mobile,
            'status'                =>  $request->status,
            'state_id'              =>  $request->state,
            'city_id'               =>  $request->city,
            'address'               =>  $request->address,
            'uploadCS'              =>  $request->uploadCS,
            'level'                 =>  $request->level,
            'sendAuto'              =>  $request->sendAuto,
            'backToWareHouse'       =>  $request->backToWareHouse,
            'backToFollowManager'   =>  $request->backToFollowManager,
            'callCenter'            =>  $request->callCenter,
            'agent_id'              =>  $request->agent_id,
            'porsantSeller'         =>  (float) str_replace(',', '', $request->porsantSeller),
            'percent'               =>  $request->percent,
            'calType'               =>  $request->calType,
            'calTypeCallCenter'     =>  $request->calTypeCallCenter,
            'callCenterType'        =>  $request->callCenterType,
            'locallyPrice'          =>  (float) str_replace(',', '', $request->locally),
            'internalPrice'         =>  (float) str_replace(',', '', $request->internal),
            'villagePrice'          =>  (float) str_replace(',', '', $request->village),
            'factorPrice'           =>  (float) str_replace(',', '', $request->factorPrice),
            'allowNumber'           =>  $request->allowNumber,
            'backToSeller'          =>  $request->backToSeller,
            'allowNumberEdit'       =>  $request->allowNumberEdit,
            'allowNumberDup'        =>  $request->allowNumberDup,
            'allowNewOrder'         =>  $request->allowNewOrder,
            'messageStatus'         =>  $request->messageStatus,
            'determinPercent'       =>  $request->determinPercent,
            'porsantType'           =>  $request->porsantType,
            'forceOrder'            =>  $request->forceOrder
        ]);
        
        

        $user->assignRole($request->role);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $uri = url()->previous();
      $sessionURL =  session(['uri' => $uri ]);
       
      $roles  = Role::latest()->get();
      $cities         =   City::latest()->get();
      $states         =   State::latest()->get();
      $user = User::findOrFail($id);
      $agentChiefs    =   User::Role('agentChief')->get();
      $callCenters    =   User::Role('callCenter')->get();
      return view('Admin.User.users-edit',compact(
          'user',
          'roles',
          'cities',
          'states',
          'callCenters',
          'agentChiefs'));
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
       
      $user = User::findOrFail($id);
    //   if(isset($request->username)){
    //       $username = $request->username;
    //   }else{
    //       $username = $user->username;
    //   }
   

        
      $user->update([
       'name'               =>  $request->name,
       'family'             =>  $request->family,
       'sex'                =>  $request->sex,
    //    'username'           =>  $username,
    //    'password'           =>  Hash::make($request->password),
       'mobile'             =>  $request->mobile,
       'status'             =>  $request->status,
       'state_id'           =>  $request->state,
       'city_id'            =>  $request->city,
       'address'            =>  $request->address,
    //    'uploadCS'           =>  $user->uploadCS,
       'level'              =>  $request->level,
       'sendAuto'           =>  $request->sendAuto,
       'backToWareHouse'    =>  $request->backToWareHouse,
       'backToFollowManager'=>  $request->backToFollowManager,
       'callCenter'         =>  $request->callCenter,
       'agent_id'           =>  $request->agent_id,
       'porsantSeller'      =>  (float) str_replace(',', '', $request->porsantSeller),
       'percent'            =>  $request->percent,
       'calType'            =>  $request->calType,
       'calTypeCallCenter'  =>  $request->calTypeCallCenter,
       'locallyPrice'       =>  (float) str_replace(',', '', $request->locally),
       'internalPrice'      =>  (float) str_replace(',', '', $request->internal),
       'villagePrice'       =>  (float) str_replace(',', '', $request->village),
       'factorPrice'        =>  (float) str_replace(',', '', $request->factorPrice),
       'callCenterType'     =>  $request->callCenterType,
       'allowNumber'        =>  $request->allowNumber,
       'backToSeller'       =>  $request->backToSeller,
       'allowNumberDup'     =>  $request->allowNumberDup,
       'allowNumberEdit'    =>  $request->allowNumberEdit,
       'allowNewOrder'      =>  $request->allowNewOrder,
       'messageStatus'      =>  $request->messageStatus,
       'determinPercent'    =>  $request->determinPercent,
       'porsantType'        =>  $request->porsantType,
       'forceOrder'         =>  $request->forceOrder
     ]);
       
     
     $user->assignRole($request->role);

     if(session('uri')){
        return redirect(session('uri'))
        ->with('message','اطلاعات کاربر با موفقیت به روز رسانی شد');
     }
     return redirect()->route('users.index')
     ->with('message','اطلاعات کاربر با موفقیت به روز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        User::destroy($id);
        return redirect()->route('users.index');
    }
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    |*/
    public function AdminDashboard(){
        $today = Carbon::now();
        $yesterday = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);
        // callcenter created order
        $OrderCreatedByCallcenterToday = Order::where([
            ['created_at','<=',$today],
            ['created_at','>=',$yesterday]
        ])->count();
        $OrderCreatedByCallcenterInMonth = Order::where([
            ['created_at','<=',$today],
            ['created_at','>=',$ThirtyDaysAgo],
        ])->count();
        //Order Waiting For Delivery  
        $OrderWaitingForDeliveryToday = Order::where([
            ['status','=',7],
            ['delivary_Date','<=',$today],
            ['delivary_Date','>=',$yesterday]
        ])->count();
        $OrderWaitingForDeliveryInMonth = Order::where([
            ['status','=',7],
            ['delivary_Date','<=',$today],
            ['delivary_Date','>=',$ThirtyDaysAgo],
        ])->count();
        //Returned Collected  
        $OrderReturnedToday = Order::where([
            ['status','=',14],
            ['updated_at','=<',$today],
            ['updated_at','=>',$yesterday]
        ])
        ->orWhere([
            ['status','=',13],
            ['updated_at','<=',$today],
            ['updated_at','>=',$yesterday]
        ])
        ->orWhere([
            ['status','=',16],
            ['updated_at','<=',$today],
            ['updated_at','>=',$yesterday]
        ])
        ->count();
        $OrderReturnedInMonth = Order::where([
            ['status','=',14],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
        ])
        ->orWhere([
            ['status','=',13],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
        ])
        ->orWhere([
            ['status','=',16],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
        ])
        ->count();
        //Order Collected 
        $OrderCollectedToday = Order::where([
            ['status','=',10],
            ['updated_at','<=',$today],
            ['updated_at','>=',$yesterday]
        ])
        ->orWhere([
            ['status','=',11],
            ['updated_at','<=',$today],
            ['updated_at','>=',$yesterday]
        ])
        ->orWhere([
            ['status','=',12],
            ['updated_at','<=',$today],
            ['updated_at','>=',$yesterday]
        ])
        ->count();
        $OrderCollectedInMonth = Order::where([
            ['status','=',10],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])
        ->orWhere([
            ['status','=',11],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
        ])
        ->orWhere([
            ['status','=',12],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
        ])
        ->count();
        // Tables
        $products = Product::latest()->get();
        $todayProducts = array();
        foreach($products as $product){
            $TopProductsToday = OrderProduct::where([
                ['collected','=',True],
                ['product_id','=',$product->id],
                ['updated_at','<',$today],
                ['updated_at','>',$yesterday]
            ])->latest()->sum('count');
            
            $todayProducts[] = [
                'name'  =>  $product->name,
                'count' =>  $TopProductsToday
            ];
        }
        
       
        asort($todayProducts);
        

        $TopStoreRooms =  OrderProduct::with('product')->select('product_id')
        ->groupBy('product_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(10)
        ->get();

        $topProductToday = array();
        $topProduct = array();
        

        foreach($TopStoreRooms as $item){
            
            $name = $item->product->name;
            $count = OrderProduct::where([
                ['product_id','=',$item->product_id],
                ['collected','=',True]
            ])->sum('count');
            
                $topProduct[]=[
                    'name'  =>  $name,
                    'count' =>  $count
                ];

           
        }
        
        asort($topProduct);
   


        

        $DebtorAgents = UserInventory::where('agent_id','!=',null)
        ->latest('balance')->skip(0)->take(10)->get();

        $agents = array();
        foreach($DebtorAgents as $DebtorItem){
            $agent_id   =   $DebtorItem->agent_id;
            $agent      =   User::findOrFail($agent_id);
            $price      =   Order::where([
                ['collected_Date','!=',Null],
                ['agent_id','=',$agent_id]
            ])->sum('cashPrice');
            
            $sharedPrice = $DebtorItem->balance;

            $costs = PaymentCirculation::where([
                ['user_id','=',$agent->id],
                ['status_id','=',5]
            ])->sum('bill');

            $payment = PaymentCirculation::where([
                ['user_id','=',$agent->id],
                ['status_id','=',2]
            ])->sum('bill');

            $agents[] = [
                'name'          =>  $agent->name.' '.$agent->family,
                'state_city'    =>  $agent->state->name.'-'.$agent->city->name,
                'price'         =>  $price  - ($sharedPrice + $payment + $costs)
            ];
             
        }

        asort($agents);
        
        return view('Admin/index',compact(
            'OrderCreatedByCallcenterToday',
            'OrderCreatedByCallcenterInMonth',
            'OrderWaitingForDeliveryToday',
            'OrderWaitingForDeliveryInMonth',
            'OrderCollectedToday',
            'OrderCollectedInMonth',
            'OrderReturnedToday',
            'OrderReturnedInMonth',
            'topProduct',
            'agents',
            'todayProducts'

        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Chart Api
    |--------------------------------------------------------------------------
    |*/
    public function AdminDashboardChartApi(){
        /* ############ Charts ############## */
        $today      = Carbon::now();
        $yesterday  = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);
        $days = $ThirtyDaysAgo->diffInDays($today);
        
        $charts = array();
        for($i=0;$i <= $days ;$days--){
            
            //Collected Charts  
            $collectedCharts = Order::where([
                ['status','=',10],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])->orWhere([
                ['status','=',11],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])
            ->orWhere([
                ['status','=',12],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])
            ->get();
            $collectedCharts = $collectedCharts->toArray();
           
            // Cancelled Charts
            $cancelledCharts = Order::where([
                ['status','=',13],
                ['cancelled_Date','<=',$today],
                ['cancelled_Date','>=',$yesterday]
            ])
            ->orWhere([
                ['status','=',16],
                ['cancelled_Date','<=',$today],
                ['cancelled_Date','>=',$yesterday]
            ])
            ->get();
            $cancelledCharts = $cancelledCharts->toArray();
            // Subsended Charts
            $subsendedCharts = Order::Where([
                ['delivary_Date','<=',$today],
                ['delivary_Date','>=',$yesterday]
            ])
            ->get();
            $subsendedCharts = $subsendedCharts->toArray();
            $charts[] =[
                'Date'          =>  $today->toDateString(),
                'subsended'     =>  count($subsendedCharts),
                'cancelled'     =>  count($cancelledCharts),
                'collected'     =>  count($collectedCharts)
            ]; 
         
            $today->subDays(1);
            $yesterday->subDays(1);
        }
  
        return Response()->json([$charts],200,[],JSON_UNESCAPED_UNICODE);
    }

    /*
    |--------------------------------------------------------------------------
    | Agent Details
    |--------------------------------------------------------------------------
    |*/
    public function agents()
    {
        $products = Product::all();
        $users = User::Role('agent')->get();
        return view('Admin.User.users-agents',compact('users','products'));
    }
    /*
    |--------------------------------------------------------------------------
    | Sellers Details
    |--------------------------------------------------------------------------
    |*/
    public function sellers(){
      $users = User::with("callCenter")->Role(['seller'])->get();
      return view('Admin.User.users-sellers',compact('users'));
    }
    /*
    |--------------------------------------------------------------------------
    | CallCenters Details
    |--------------------------------------------------------------------------
    |*/
    public function callCenter(){
        $users = User::Role(['callCenter'])->get();
        return view('Admin.User.users-callCenters',compact('users'));
    }
    /*
    |--------------------------------------------------------------------------
    | switch to Another Account Without log-out
    |--------------------------------------------------------------------------
    |*/
    public function switchAccount($id){
        $user_id = auth()->user()->id;
        $user = User::findOrFail($id);
        Auth::login($user);
        $role = $user->getRoleNames()->first();
       
        session(['adminLogIn' => $user_id ]);
        $uri = url()->previous();
        session(['switchUsersURI' => $uri ]);

        if($role == "mainWarehouser" || $role == "fundWarehouser"){
            return redirect()->route('storeRooms.index')->with('switchSuccess','true');
        }elseif($role == "agent"){
            return redirect()->route('users.AgentDashboard')->with('switchSuccess','true');
        }elseif($role == "agentChief"){
            return redirect()->route('users.AgentChiefDashboard')->with('switchSuccess','true');
        }elseif($role == "seller"){
            return redirect()->route('users.SellerDashboard')->with('switchSuccess','true');
        }elseif($role == "followUpManager"){
            return redirect()->route('orders.UnverifiedOrderList')->with('switchSuccess','true');
        }else{
            return redirect('/')->with('switchSuccess','true');
        }
        
    }
    /*
    |--------------------------------------------------------------------------
    | Back To Perivouse Account
    |--------------------------------------------------------------------------
    |*/
    public function backToPerivouseAccount(){
        $id= session()->pull('adminLogIn');
        $user = User::findOrFail($id);
        Auth::login($user);
        session()->forget('adminLogIn');
        if(session('switchUsersURI')){
            return redirect(session('switchUsersURI'));
        }
        return redirect()->route('users.index');
    }
    /*
    |--------------------------------------------------------------------------
    | User Public Edit
    |--------------------------------------------------------------------------
    |*/
    public function userPublicEdit($id){
        $user = User::findOrFail($id);
        return view('Admin.User.users-edit-pass',compact('user'));
    }
    /*
    |--------------------------------------------------------------------------
    | User Public Update
    |--------------------------------------------------------------------------
    |*/
    public function userPublicUpdate(Request $request,$id){
        $request->validate([
            'password'  =>  'required'
        ],[
            'password.required'  =>  'گذرواژه خالی ست'
        ]);
        $user = User::findOrFail($id);
       
        if($request->hasFile('image')){
            $media = $user->addMedia($request->File('image'))->toMediaCollection('Useravatar');
           
            $user->update([
                'image_id'  =>  $media->id,
            ]);
        }
        if($request->hasFile('uploadCS')){
            Storage::disk('public')->delete($user->uploadCS);
            $uploadCS = Storage::disk('public')->put('UploadCS',$request->uploadCS);
            $user->update(['uploadCS'=>$uploadCS]);
        }else{
            $user->update(['uploadCS'=>$user->uploadCS]);
        }
        $user->update([
            'password'  =>  Hash::make($request->password)
        ]);
        if($user->id == auth()->user()->id){
            Auth::login($user);
        }
        
        return redirect()->route('users.public.edit',[$user->id])->with('message','مشخصات به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Dashboard Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentDashboard(Request $request){

        $user = User::findOrFail(auth()->user()->id);
        $WaitingForDelivery = Order::where([
            ['status','=',7],
            ['agent_id','=',$user->id]
        ])->get();
        $subsended  =   Order::where([
            ['status','=',14],
            ['agent_id','=',$user->id]
        ])->get();
        
        $Returned   =   Order::where(['status'=>14,'agent_id'=>$user->id])->get();
        
        $userAllOrders  =   Order::where('agent_id',$user->id)->get()->count();
  
        $collected      =   Order::where([
            ['status','=',10],
            ['agent_id','=',$user->id]
        ])
        ->orWhere([
            ['status','=',11],
            ['agent_id','=',$user->id]
        ])
        ->orWhere([
            ['status','=',12],
            ['agent_id','=',$user->id]
        ])
        ->get();
        if($collected->count() != 0){
            $collectedPercent = round (($collected->count() * 100 ) / $userAllOrders , 2) ;
        }else{
            $collectedPercent = 0;
        }
        /* All Sells in this mounth  */
        $today      = Carbon::now();
        $yesterday  = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);

      
            

        $user = User::findOrFail(auth()->user()->id);
        $AllSell = 
        MoneyCirculation::where('agent_id',$user->id)->sum('amount');
            
        $AllSpecialShared = UserInventory::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');
            
        $TotalSettle = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);

        $totalDebtor = Order::where([
            ['agent_id','=',$user->id],
            ['collected_Date','!=',null]
        ])->sum('cashPrice');
        $totalCreditor = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['confirmDate','!=',null]
        ])
        ->sum('bill');
        
        // $AllSell =   Order::where([
        //     ['collected_Date','!=',Null],
        //     ['agent_id','=',$user->id]
        // ])->sum('cashPrice');

        $orders = Order::with("products")->where([
            ["collected_Date","!=", Null],
            ["agent_id","=", $user->id]
        ])->get();
        
        $Discount = 0;
        foreach( $orders as $order ) {
            $Discount += $order->products->sum("off");
        }

        
   
        $costs = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',5]
        ])->sum('bill');

        $payments = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');

        $AllSpecialShared = UserInventory::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');


        $Allpayments = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',5]
        ])
        ->get();

        $AllOrders = Order::where([
            ['collected_Date','!=',Null],
            ['agent_id','=',$user->id]
        ])->get();
        $Allpayments = $Allpayments->toArray();
        $AllOrders = $AllOrders->toArray();
        $transaction = array_merge($AllOrders,$Allpayments);

        $payback = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id', '=', 8],
            ['confirmDate','!=', null]
        ])
        ->sum("bill");
 

        return view('Admin.agent-index',compact(
            'WaitingForDelivery',
            'collected',
            'Returned',
            'collectedPercent',
            'subsended',
            'user',
            'AllSell',
            'AllSpecialShared',
            'payments',
            'costs',
            'TotalSettle',
            'user',
            'totalDebtor',
            'totalCreditor',
            'transaction',
            'Discount',
            'payback'
      
         
        
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Dashboard Chart Api
    |--------------------------------------------------------------------------
    |*/
    public function AgentDashboardChartApi($userID) {

        /* ############ Charts ############## */
        $today      = Carbon::now();
        $yesterday  = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);
        $days = $ThirtyDaysAgo->diffInDays($today);
        
        $charts = array();
        for($i=0;$i <= $days ;$days--){
            
            //Collected Charts  
            $collectedCharts = Order::where([
                ['status','=',10],
                ['agent_id','=',$userID],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])->orWhere([
                ['status','=',11],
                ['agent_id','=',$userID],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])
            ->orWhere([
                ['status','=',12],
                ['agent_id','=',$userID],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ])
            ->get();
            $collectedCharts = $collectedCharts->toArray();
           
            // Cancelled Charts
            $cancelledCharts = Order::where([
                ['status','=',13],
                ['agent_id','=',$userID],
                ['cancelled_Date','<=',$today],
                ['cancelled_Date','>=',$yesterday]
            ])
            ->orwhere([
                ['status','=',16],
                ['agent_id','=',$userID],
                ['cancelled_Date','<=',$today],
                ['cancelled_Date','>=',$yesterday]
            ])
            ->get();
            $cancelledCharts = $cancelledCharts->toArray();
            // Subsended Charts
            $subsendedCharts = Order::where([
                
                ['agent_id','=',$userID],
                ['delivary_Date','<=',$today],
                ['delivary_Date','>=',$yesterday]
            ])->get();
            $subsendedCharts = $subsendedCharts->toArray();
            $charts[] =[
                'Date' => $today->toDateString(),
                'subsended'   =>  count($subsendedCharts),
                'cancelled'   =>  count($cancelledCharts),
                'collected'   =>  count($collectedCharts)
            ]; 
         
            $today->subDays(1);
            $yesterday->subDays(1);
        }
  
        return Response()->json([$charts],200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Chief Dashboard Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentChiefDashboard(){
        $user = User::findOrFail(auth()->user()->id);

        $agents = User::where('agent_id',$user->id)->latest()->get();


        $CollectedPercentDetails = array();
        foreach($agents as $agent){
            $userAllOrders  =   Order::where('agent_id',$agent->id)->get()->count();
            $collected      =   Order::where([
                ['status','=',10],
                ['agent_id','=',$agent->id]
            ])
            ->orWhere([
                ['status','=',11],
                ['agent_id','=',$agent->id]
            ])
            ->orWhere([
                ['status','=',12],
                ['agent_id','=',$agent->id]
            ])
            ->get();
            if($collected->count() != 0){
                $collectedPercent = round (($collected->count() * 100 ) / $userAllOrders , 2) ;
            }else{
                $collectedPercent = 0;
            }
            $balance = UserInventory::where('agent_id',$agent->id)->sum('balance');
            $delivaryOrders = Order::where([
                ['agent_id','=',$agent->id],
                ['status','=',7]
            ])->get();
                
            // four first boxes
            $today          = Carbon::now();
            $yesterday      = Carbon::now()->subDays(1);
            $ThirtyDaysAgo  = Carbon::now()->subDays(30);
            $days = $ThirtyDaysAgo->diffInDays($today);
                
            // collected orders in month

            // in month
            $collected_month = 0;
            foreach( $agents as $agent ) {
                $collected_month += Order::where([
                    ['agent_id', '=', $agent->id],
                    ['collected_Date','<=', $today],
                    ['collected_Date', '>=', $ThirtyDaysAgo]
                ])->count();
            }

            // in today
            $collected_today = 0;
            foreach( $agents as $agent ) {
                $collected_today += Order::where([
                    ['agent_id', '=', $agent->id],
                    ['collected_Date','<=', $today],
                    ['collected_Date', '>=', $yesterday]
                ])->count();
            }

            //cancelled orders

            // in month
            $cancelled_month = 0;
            foreach( $agents as $agent ) {
                $cancelled_month += Order::where([
                    ['agent_id', '=', $agent->id],
                    ['cancelled_Date','<=', $today],
                    ['cancelled_Date', '>=', $ThirtyDaysAgo]
                ])->count();
            }

            // in today
            $cancelled_today = 0;
            foreach( $agents as $agent ) {
                $cancelled_today += Order::where([
                    ['agent_id', '=', $agent->id],
                    ['cancelled_Date','<=', $today],
                    ['cancelled_Date', '>=', $yesterday]
                ])->count();
            }

            //Delivary Order Number
            $delivaryOrderNumber = 0;
            foreach( $agents as $agent ) {
                $delivaryOrderNumber += Order::where([
                    ['agent_id', '=', $agent->id],
                    ['status', '=', 7]
                ])->count();
              
            }




            $CollectedPercentDetails[] = [
                'name'              =>  $agent->name.' '.$agent->family,
                'city_state'        =>  $agent->state->name.'-'.$agent->city->name,
                'percent'           =>  $collectedPercent,
                'balance'           =>  $balance,
                'delivaryOrders'    =>  count($delivaryOrders),
            ];
        }


        return view('Admin.agentChief-index',compact(
            'CollectedPercentDetails',
            'delivaryOrderNumber',
            'collected_month',
            'collected_today',
            'cancelled_month',
            'cancelled_today'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Agent Chief Dashboard Chart Api
    |--------------------------------------------------------------------------
    |*/
    public function AgentChiefDashboardChartApi() {

        $user = auth()->user();
        $users = User::where("agent_id", $user->id)->get();
        /* ############ Charts ############## */
        $today      = Carbon::now();
        $yesterday  = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);
        $days = $ThirtyDaysAgo->diffInDays($today);
        
        $charts = array();
        for($i=0;$i <= $days ;$days--) {
            
            //Collected Charts  
            $collectedCharts = Order::where([
                ['agent_id','=',$user->id],
                ['collected_Date','<=',$today],
                ['collected_Date','>=',$yesterday]
            ]);

            foreach( $users as $item ) {
                $collectedCharts->orWhere([
                    ['agent_id','=',$item->id],
                    ['collected_Date','<=',$today],
                    ['collected_Date','>=',$yesterday]
                ]);
            }
            $collectedCharts = $collectedCharts->get();
            $collectedCharts = $collectedCharts->toArray();
           
            // Cancelled Charts
            $cancelledCharts = Order::where([
                ['agent_id','=',$user->id],
                ['cancelled_Date','<=',$today],
                ['cancelled_Date','>=',$yesterday]
            ]);

            foreach( $users as $item ) {
                $cancelledCharts->orWhere([
                    ['status','=', 13],
                    ['agent_id','=',$item->id],
                    ['collected_Date','<=',$today],
                    ['collected_Date','>=',$yesterday]
                ]);
                $cancelledCharts->orWhere([
                    ['status','=', 16],
                    ['agent_id','=',$item->id],
                    ['collected_Date','<=',$today],
                    ['collected_Date','>=',$yesterday]
                ]);
            }

            $cancelledCharts = $cancelledCharts->get();
            $cancelledCharts = $cancelledCharts->toArray();

            // Subsended Charts
            $subsendedCharts = Order::where([
                ['agent_id','=',$user->id],
                ['delivary_Date','<=',$today],
                ['delivary_Date','>=',$yesterday]
            ]);
            
            foreach( $users as $item ) {
                $subsendedCharts->orWhere([
                    ['status','=', 7],
                    ['agent_id','=',$user->id],
                    ['delivary_Date','<=',$today],
                    ['delivary_Date','>=',$yesterday]
                ]);
            }

            $subsendedCharts = $subsendedCharts->get();
            $subsendedCharts = $subsendedCharts->toArray();

            $charts[] =[
                'Date'        =>  $today->toDateString(),
                'subsended'   =>  count($subsendedCharts),
                'cancelled'   =>  count($cancelledCharts),
                'collected'   =>  count($collectedCharts)
            ]; 
         
            $today->subDays(1);
            $yesterday->subDays(1);
        }
  
        return Response()->json($charts,200,[],JSON_UNESCAPED_UNICODE);


    }

    /*
    |--------------------------------------------------------------------------
    | Seller Dashboard Page
    |--------------------------------------------------------------------------
    |*/
    public function SellerDashboard(){
        return view('Admin.seller-index');
    }
    /*
    |--------------------------------------------------------------------------
    | Apply uploadCS
    |--------------------------------------------------------------------------
    |*/
    public function uploadCS_status($id,Request $request){
        $user = User::findOrFail($id);
        $user->update(['uploadCS_status'=>$request->status]);
        if($request->status != null){
            $message = "مدارک ".$user->name.' '.$user->family.' تایید شد';
        }else{
            $message = "مدارک ".$user->name.' '.$user->family.' از حالت تایید خارج شد';
        }
        return back()->with('message',$message);
    }
    /*
    |--------------------------------------------------------------------------
    | Follow Up Manager State Store
    |--------------------------------------------------------------------------
    |*/
    public function followUpManagerStateStore(Request $request){
        $id = $request->user_id;
        
        $stateExists = State::where('name',$request->StateName)->exists();
       
        if($stateExists == false){
            return redirect()->route('users.edit',[$id])->with('info','ابتدا این استان را در سیستم ذخیره کنید');
        }

        $status = State::where([
            ['name','=',$request->StateName],
            ['followUpManager','!=',null]
        ])->exists();

        if($status == True){
            return redirect('/users/'.$id.'/edit#statesUnderControl')->with('info','استان انتخاب شده قبلا در سیستم ثبت شده');
        }else{
           
            $city = State::where('name',$request->StateName)->firstOrFail();
            $city->update(['followUpManager'=>$id]);
            return redirect('/users/'.$id.'/edit#statesUnderControl')->with('info','این استان به این مدیر پیگیری اختصاص پیدا کرد');
        }

    }
    /*
    |--------------------------------------------------------------------------
    | Follow Up Manager City Clear
    |--------------------------------------------------------------------------
    |*/
    public function followUpManagerStateClear($StateName){
        $state = State::where('name',$StateName)->firstOrFail();
        $id = $state->followUpManager;
        $state->update(['followUpManager'=>null]);
        return redirect('/users/'.$id.'/edit#statesUnderControl')->with('info','این استان از لیست این مدیر پیگیری خارج شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Center Add New Order Change
    |--------------------------------------------------------------------------
    |*/
    public function callCenterAddNewOrderChange(Request $request,$id){

        $user = User::findOrFail($id);
        $user->update(['allowNewOrder'=>$request->allowNewOrder]);
        return Response()->json('با موفقیت ثبت سفارش تغییر کرد',
        200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Lists For Agent Chief
    |--------------------------------------------------------------------------
    |*/
    public function AgentListsForAgentChief(){
        $user_id    =   auth()->user()->id;
        $user       =   User::findOrFail($user_id);

        $users      =   User::where('agent_id',$user_id)->latest()->get();
        
        return view('Admin.User.AgentChief.agents-list',compact('users'));
    }


}
