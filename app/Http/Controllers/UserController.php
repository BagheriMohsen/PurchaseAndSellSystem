<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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

        $users = User::latest()->paginate(10);
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
        $agentChiefs    =   User::Role('agentChief')->get();
        $callCenters    =   User::Role('callCenter')->get();
        return view('Admin.User.users-create',compact('cities','roles','agentChiefs','callCenters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $user = User::create([
            'name'                  =>  $request->name,
            'family'                =>  $request->family,
            'sex'                   =>  $request->sex,
            'username'              =>  $request->username,
            'password'              =>  Hash::make($request->password),
            'mobile'                =>  $request->mobile,
            'status'                =>  $request->status,
            'state_id'              =>  $request->state,
            'address'               =>  $request->address,
            'uploadCS'              =>  $request->uploadCS,
            'level'                 =>  $request->level,
            'sendAuto'              =>  $request->sendAuto,
            'reciveAuto'            =>  $request->reciveAuto,
            'callCenter'            =>  $request->callCenter,
            'agent_id'              =>  $request->agent_id,
            'porsantSeller'         =>  $request->porsantSeller,
            'percent'               =>  $request->percent,
            'calType'               =>  $request->calType,
            'calTypeCallCenter'     =>  $request->calTypeCallCenter,
            'callCenterType'        =>  $request->callCenterType,
            'locallyPrice'          =>  $request->locally,
            'internalPrice'         =>  $request->internal,
            'villagePrice'          =>  $request->village,
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
      $cities = 'App\City'::latest()->get();
      $user = User::findOrFail($id);
      $agentChiefs    =   User::Role('agentChief')->get();
      $callCenters    =   User::Role('callCenter')->get();
      return view('Admin.User.users-edit',compact('user','roles','cities','callCenters','agentChiefs'));
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
      $user->update([
       'name'               =>  $request->name,
       'family'             =>  $request->family,
       'sex'                =>  $request->sex,
       'username'           =>  $request->username,
       'password'           =>  Hash::make($request->password),
       'mobile'             =>  $request->mobile,
       'status'             =>  $request->status,
       'state_id'           =>  $request->state,
       'address'            =>  $request->address,
       'uploadCS'           =>  $request->uploadCS,
       'level'              =>  $request->level,
       'sendAuto'           =>  $request->sendAuto,
       'reciveAuto'         =>  $request->reciveAuto,
       'callCenter'         =>  $request->callCenter,
       'agent_id'           =>  $request->agent_id,
       'porsantSeller'      =>  $request->porsantSeller,
       'percent'            =>  $request->percent,
       'calType'            =>  $request->calType,
       'calTypeCallCenter'  =>  $request->calTypeCallCenter,
       'locallyPrice'       =>  $request->locally,
       'internalPrice'      =>  $request->internal,
       'villagePrice'       =>  $request->village,
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
    | Agent Details
    |--------------------------------------------------------------------------
    |*/

    public function agents()
    {
        $products = 'App\Product'::all();
        $users = User::Role(['agent', 'agentChief'])->get();
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
    public function userPublicEdit(){
        $user = User::findOrFail(auth()->user()->id);
        return view('Admin.User.users-edit-pass',compact('user'));
    }
    /*
    |--------------------------------------------------------------------------
    | User Public Update
    |--------------------------------------------------------------------------
    |*/
    public function userPublicUpdate(Request $request){
        $request->validate([
            'password'  =>  'required'
        ],[
            'password.required'  =>  'گذرواژه خالی ست'
        ]);
        $user = User::findOrFail(auth()->user()->id);
       
        if($request->hasFile('image')){
            $media = $user->addMedia($request->File('image'))->toMediaCollection('Useravatar');
           
            $user->update([
                'image_id'  =>  $media->id
            ]);
        }
        if($request->hasFile('uploadCS')){
            Storage::disk('public')->delete($user->uploadCS);
            $uploadCS = Storage::disk('public')->put('UploadCS',$requst->uploadCS);
            $user->update(['uploadCS'=>$uploadCS]);
        }
        $user->update([
            'password'  =>  Hash::make($request->password)
        ]);
        Auth::login($user);
        return redirect()->route('users.public.edit',[$user->username])->with('message','مشخصات شما به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Dashboard Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentDashboard(Request $request){
        
        return view('Admin.agent-index');
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
    | Follow Up Manager City Store
    |--------------------------------------------------------------------------
    |*/
    public function followUpManagerCityStore(Request $request){
        $id = $request->user_id;
        
        $cityExists = 'App\City'::where('name',$request->CityName)->exists();
       
        if($cityExists == false){
            return redirect()->route('users.edit',[$id])->with('info','ابتدا این شهر را در سیستم ذخیره کنید');
        }

        $status = 'App\City'::where([
            ['name','=',$request->CityName],
            ['followUpManager','!=',null]
        ])->exists();

        if($status == True){
            return redirect()->route('users.edit',[$id])->with('info','شهر انتخاب شده قبلا در سیستم ثبت شده');
        }else{
           
            $city = 'App\City'::where('name',$request->CityName)->firstOrFail();
            $city->update(['followUpManager'=>$id]);
            return redirect()->route('users.edit',[$id])->with('message','این شهر به این مدیر پیگیری اختصاص پیدا کرد');
        }

    }
    /*
    |--------------------------------------------------------------------------
    | Follow Up Manager City Clear
    |--------------------------------------------------------------------------
    |*/
    public function followUpManagerCityClear($CityName){
        $city = 'App\City'::where('name',$CityName)->firstOrFail();
        $id = $city->followUpManager;
        $city->update(['followUpManager'=>null]);
        return redirect()->route('users.edit',[$id])->with('message','این شهر از لیست این مدیر پیگیری خارج شد');
    }


}
