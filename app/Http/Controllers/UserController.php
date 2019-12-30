<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use Carbon\Carbon;
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
        
        $cities         =   'App\City'::latest()->get();
        $states         =   'App\State'::latest()->get();
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
      $cities         =   'App\City'::latest()->get();
      $states         =   'App\State'::latest()->get();
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
        $today = 'Carbon\Carbon'::now();
        $yesterday = 'Carbon\Carbon'::now()->subDays(1);
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
        // callcenter created order
        $OrderCreatedByCallcenterToday = 'App\Order'::where([
            ['created_at','<=',$today],
            ['created_at','>=',$yesterday]
        ])->count();
        $OrderCreatedByCallcenterInMonth = 'App\Order'::where([
            ['created_at','<=',$today],
            ['created_at','>=',$ThirtyDaysAgo],
        ])->count();
        //Order Waiting For Delivery  
        $OrderWaitingForDeliveryToday = 'App\Order'::where([
            ['status','=',7],
            ['delivary_Date','<=',$today],
            ['delivary_Date','>=',$yesterday]
        ])->count();
        $OrderWaitingForDeliveryInMonth = 'App\Order'::where([
            ['status','=',7],
            ['delivary_Date','<=',$today],
            ['delivary_Date','>=',$ThirtyDaysAgo],
        ])->count();
        //Returned Collected  
        $OrderReturnedToday = 'App\Order'::where([
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
        $OrderReturnedInMonth = 'App\Order'::where([
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
        $OrderCollectedToday = 'App\Order'::where([
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
        $OrderCollectedInMonth = 'App\Order'::where([
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
        $products = 'App\Product'::latest()->get();
        $todayProducts = array();
        foreach($products as $product){
            $TopProductsToday = 'App\OrderProduct'::where([
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
        

        $TopStoreRooms =  'App\OrderProduct'::with('product')->select('product_id')
        ->groupBy('product_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(10)
        ->get();

        $topProductToday = array();
        $topProduct = array();
        

        foreach($TopStoreRooms as $item){
            
            $name = $item->product->name;
            $count = 'App\OrderProduct'::where([
                ['product_id','=',$item->product_id],
                ['collected','=',True]
            ])->sum('count');
            
                $topProduct[]=[
                    'name'  =>  $name,
                    'count' =>  $count
                ];

           
        }
        
        asort($topProduct);
   


        

        $DebtorAgents = 'App\UserInventory'::where('agent_id','!=',null)
        ->latest('balance')->skip(0)->take(10)->get();

        $agents = array();
        foreach($DebtorAgents as $DebtorItem){
            $agent_id   =   $DebtorItem->agent_id;
            $agent      =   'App\User'::findOrFail($agent_id);
            $price      =   'App\Order'::where([
                ['collected_Date','!=',Null],
                ['agent_id','=',$agent_id]
            ])->sum('cashPrice');
               
            $agents[] = [
                'name'          =>  $agent->name.' '.$agent->family,
                'state_city'    =>  $agent->state->name.'-'.$agent->city->name,
                'price'         =>  $price - $DebtorItem->balance 
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
        $today      = 'Carbon\Carbon'::now();
        $yesterday  = 'Carbon\Carbon'::now()->subDays(1);
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
        $days = $ThirtyDaysAgo->diffInDays($today);
        
        $charts = array();
        for($i=0;$i <= $days ;$days--){
            
            //Collected Charts  
            $collectedCharts = 'App\Order'::where([
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
            $cancelledCharts = 'App\Order'::where([
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
            $subsendedCharts = 'App\Order'::Where([
                ['delivary_Date','<=',$today],
                ['delivary_Date','>=',$yesterday]
            ])
            ->get();
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
    | Agent Details
    |--------------------------------------------------------------------------
    |*/

    public function agents()
    {
        $products = 'App\Product'::all();
        $users = User::Role('agent')->get();
        return view('Admin.User.users-agents',compact('users','products'));
    }
    /*
    |--------------------------------------------------------------------------
    | Sellers Details
    |--------------------------------------------------------------------------
    |*/
    public function sellers(){
      $users = User::Role(['seller'])->get();
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
        $WaitingForDelivery = 'App\Order'::where([
            ['status','=',7],
            ['agent_id','=',$user->id]
        ])->get();
        $subsended  =   'App\Order'::where([
            ['status','=',14],
            ['agent_id','=',$user->id]
        ])->get();
        
        $Returned   =   'App\Order'::where(['status'=>14,'agent_id'=>$user->id])->get();
        
        $userAllOrders  =   'App\Order'::where('agent_id',$user->id)->get()->count();
  
        $collected      =   'App\Order'::where([
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
        $today      = 'Carbon\Carbon'::now();
        $yesterday  = 'Carbon\Carbon'::now()->subDays(1);
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);

        $AllSell = 
        'App\MoneyCirculation'::where('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)->sum('amount');
            
        $AllSpecialShared = 'App\UserInventory'::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');
            
        $TotalSettle = 'App\PaymentCirculation'::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');

        return view('Admin.agent-index',compact(
            'WaitingForDelivery',
            'collected',
            'Returned',
            'collectedPercent',
            'subsended',
            'user',
            'AllSell',
            'AllSpecialShared',
            'TotalSettle'
         
        
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Dashboard Chart Api
    |--------------------------------------------------------------------------
    |*/
    public function AgentDashboardChartApi($userID){
        /* ############ Charts ############## */
        $today      = 'Carbon\Carbon'::now();
        $yesterday  = 'Carbon\Carbon'::now()->subDays(1);
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
        $days = $ThirtyDaysAgo->diffInDays($today);
        
        $charts = array();
        for($i=0;$i <= $days ;$days--){
            
            //Collected Charts  
            $collectedCharts = 'App\Order'::where([
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
            $cancelledCharts = 'App\Order'::where([
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
            $subsendedCharts = 'App\Order'::where([
                
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
            $userAllOrders  =   'App\Order'::where('agent_id',$agent->id)->get()->count();
            $collected      =   'App\Order'::where([
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
            $balance = 'App\UserInventory'::where('agent_id',$agent->id)->sum('balance');
            $delivaryOrders = 'App\Order'::where([
                ['agent_id','=',$agent->id],
                ['status','=',7]
            ])->get();
            
            $CollectedPercentDetails[] = [
                'name'              =>  $agent->name.' '.$agent->family,
                'city_state'        =>  $agent->state->name.'-'.$agent->city->name,
                'percent'           =>  $collectedPercent,
                'balance'           =>  $balance,
                'delivaryOrders'    =>  count($delivaryOrders) 
            ];
        }


        return view('Admin.agentChief-index',compact(
            'CollectedPercentDetails'
        ));
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
        
        $stateExists = 'App\State'::where('name',$request->StateName)->exists();
       
        if($stateExists == false){
            return redirect()->route('users.edit',[$id])->with('info','ابتدا این استان را در سیستم ذخیره کنید');
        }

        $status = 'App\State'::where([
            ['name','=',$request->StateName],
            ['followUpManager','!=',null]
        ])->exists();

        if($status == True){
            return redirect('/users/'.$id.'/edit#statesUnderControl')->with('info','استان انتخاب شده قبلا در سیستم ثبت شده');
        }else{
           
            $city = 'App\State'::where('name',$request->StateName)->firstOrFail();
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
        $state = 'App\State'::where('name',$StateName)->firstOrFail();
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

        $user = 'App\User'::findOrFail($id);
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
        $user       =   'App\User'::findOrFail($user_id);

        $users      =   'App\User'::where('agent_id',$user_id)->latest()->get();
        
        return view('Admin.User.AgentChief.agents-list',compact('users'));
    }


}
