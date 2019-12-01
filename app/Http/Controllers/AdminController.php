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
      if($role == "mainWarehouser"){
        return redirect()->route('storeRooms.index');
      }else{
        return redirect()->route('users.AdminDashboard');
      }
      

    }




}
