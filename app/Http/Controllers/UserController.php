<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
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

        $roles          =   Role::latest()->get();
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
            'allowNumber'           =>  $request->allowNumber,
            'allowNumberBack'       =>  $request->allowNumberBack,
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
      if(isset($request->username)){
          $username = $request->username;
      }else{
          $username = $user->username;
      }
     

        
      $user->update([
       'name'               =>  $request->name,
       'family'             =>  $request->family,
       'sex'                =>  $request->sex,
       'username'           =>  $username,
       'password'           =>  Hash::make($request->password),
       'mobile'             =>  $request->mobile,
       'status'             =>  $request->status,
       'state_id'           =>  $request->state,
       'city_id'            =>  $request->city,
       'address'            =>  $request->address,
       'uploadCS'           =>  $user->uploadCS,
       'level'              =>  $request->level,
       'sendAuto'           =>  $request->sendAuto,
       'backToWareHouse'    =>  $request->backToWareHouse,
       'callCenter'         =>  $request->callCenter,
       'agent_id'           =>  $request->agent_id,
       'porsantSeller'      =>  (float) str_replace(',', '', $request->porsantSeller),
       'percent'            =>  $request->percent,
       'calType'            =>  $request->calType,
       'calTypeCallCenter'  =>  $request->calTypeCallCenter,
       'locallyPrice'       =>  (float) str_replace(',', '', $request->locally),
       'internalPrice'      =>  (float) str_replace(',', '', $request->internal),
       'villagePrice'       =>  (float) str_replace(',', '', $request->village),
       'callCenterType'     =>  $request->callCenterType,
       'allowNumber'        =>  $request->allowNumber,
       'allowNumberBack'    =>  $request->allowNumberBack,
       'allowNumberDup'     =>  $request->allowNumberDup,
       'allowNumberEdit'    =>  $request->allowNumberEdit,
       'allowNewOrder'      =>  $request->allowNewOrder,
       'messageStatus'      =>  $request->messageStatus,
       'determinPercent'    =>  $request->determinPercent,
       'porsantType'        =>  $request->porsantType,
       'forceOrder'         =>  $request->forceOrder
     ]);
       
     
     $user->assignRole($request->role);
     return redirect()->route('users.index');
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
        
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
        //Order Waiting For Delivery  
        $OrderWaitingForDeliveryToday = 'App\Order'::where([
            ['status','=',7],
            ['updated_at','=',$today->toDateString()],
        ])->count();
        $OrderWaitingForDeliveryInMonth = 'App\Order'::where([
            ['status','=',7],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])->count();
        //Returned Collected  
        $OrderReturnedToday = 'App\Order'::where([
            ['status','=',14],
            ['updated_at','=',$today->toDateString()],
        ])->count();
        $OrderReturnedInMonth = 'App\Order'::where([
            ['status','=',14],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])->count();
        //Order Collected 
        $OrderCollectedToday = 'App\Order'::where([
            ['status','=',13],
            ['updated_at','=',$today->toDateString()],
        ])->count();
        $OrderCollectedInMonth = 'App\Order'::where([
            ['status','=',13],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])->count();
        return view('Admin/index',compact(
            'OrderWaitingForDeliveryToday',
            'OrderWaitingForDeliveryInMonth',
            'OrderCollectedToday',
            'OrderCollectedInMonth',
            'OrderReturnedToday',
            'OrderReturnedInMonth'

        ));
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
        $WaitingForDelivery = 'App\Order'::where(['status'=>7,'agent_id'=>$user->id])->get();
        $subsended  =   'App\Order'::where(['status'=>15,'agent_id'=>$user->id])->get();
        $Returned   =   'App\Order'::where(['status'=>14,'agent_id'=>$user->id])->get();
        
        $userAllOrders  =   'App\Order'::where('agent_id',$user->id)->get()->count();
  
        $collected      =   'App\Order'::where(['status'=>13,'agent_id'=>$user->id])->get();
        if($collected->count() != 0){
            $collectedPercent = ($collected->count() * 100 ) / $userAllOrders ;
        }else{
            $collectedPercent = 0;
        }
       
        
    
        return view('Admin.agent-index',compact(
            'WaitingForDelivery',
            'collected',
            'Returned',
            'collectedPercent',
            'subsended',
            'user',
         
        
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Dashboard Chart Api
    |--------------------------------------------------------------------------
    |*/
    public function AgentDashboardChartApi($userID){
        /* ############ Charts ############## */
        $today = 'Carbon\Carbon'::now();
        $ThirtyDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
        //Collected Charts  
        $collectedCharts = 'App\Order'::where([
            ['status','=',13],
            ['agent_id','=',$userID],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])->get('updated_at');
        $collectedCharts = $collectedCharts->toArray();
        // Cancelled Charts
        $cancelledCharts = 'App\Order'::where([
            ['status','=',14],
            ['agent_id','=',$userID],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])->get('updated_at');
        $cancelledCharts = $cancelledCharts->toArray();
        // Subsended Charts
        $subsendedCharts = 'App\Order'::where([
            ['status','=',1],
            ['agent_id','=',$userID],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo],
        ])
        ->orWhere([
            ['status','=',15],
            ['agent_id','=',$userID],
            ['updated_at','<=',$today],
            ['updated_at','>=',$ThirtyDaysAgo]
            ])
        ->get('updated_at');
        $subsendedCharts = $subsendedCharts->toArray();
        
        return Response()->json(array(
            'subsendedCharts'=>$subsendedCharts,
            'cancelledCharts'=>$cancelledCharts,
            'collectedCharts'=>$collectedCharts
        ),200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Chief Dashboard Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentChiefDashboard(){
        return view('Admin.agentChief-index');
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


}
