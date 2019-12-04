<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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




}
