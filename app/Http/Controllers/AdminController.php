<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Carbon\Carbon;
class AdminController extends Controller
{

    public function index(){

      $user = 'App\User'::find(auth()->user()->id);
      $role = $user->getRoleNames()->first();
     
      /*------------------Gate For Role Index Page------------------ */
      if($role == "mainWarehouser" || $role == "fundWarehouser"){
        return redirect()->route('storeRooms.index');
      }elseif($role == "agent"){
          return redirect()->route('users.AgentDashboard');
      }elseif($role == "agentChief"){
          return redirect()->route('users.AgentChiefDashboard');
      }elseif($role == "seller"){
          return redirect()->route('users.SellerDashboard');
      }elseif($role == "followUpManager"){
          return redirect()->route('orders.UnverifiedOrderList');
      }else{
          return redirect()->route('users.AdminDashboard');
      }
      

    }
    /*
    |--------------------------------------------------------------------------
    | General Setting
    |--------------------------------------------------------------------------
    |*/
    public function GeneralSetting(){

        $settings       = DB::table('settings');
        $Factor         = $settings->skip(0)->take(1)->get();
        $FactorStatus   = $settings->skip(0)->take(1)->exists();  
        if($FactorStatus){
            $Factor = $Factor[0];
        }  
       
        return view('Admin.Setting.Admin.general-setting',compact(
            'settings',
            'Factor',
            'FactorStatus'
        
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | General Setting Update
    |--------------------------------------------------------------------------
    |*/
    public function GeneralSettingUpdate(Request $request,$id){
        
        $status = DB::table('settings')->where('id',$id)->exists();
        
        if($status){
            DB::table('settings')->where('id',$id)
            ->update([
                'id'            =>  $id,
                'option1'       =>  $request->option1,
                'option2'       =>  $request->option2,
                'option3'       =>  $request->option3,
                'updated_at'    =>  Carbon::now()
            ]);
        }else{
            DB::table('settings')->insert([
                'id'            =>  $id,
                'option1'       =>  $request->option1,
                'option2'       =>  $request->option2,
                'option3'       =>  $request->option3,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);
        }

        return back()->with('message','تغییرات با موفقیت انجام شد');
    }




}
