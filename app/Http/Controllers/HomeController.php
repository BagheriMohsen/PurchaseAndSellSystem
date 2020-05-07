<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/');
    }

    /**
     * .
     * LOG OUT User
     *
     */
    public function logout()
    {
        Auth()->logout();
        return redirect('/login');
    }

    /**
     *
     * Log In To Site
     *
     */
    public function loginToSite(Request $request){
       
        $status = User::where('username',$request->username)->exists();
        
        if($status == true){
          $user = User::where('username',$request->username)->firstOrFail();
         
          if($user->status != 'on'){
            return back()->with('message','دسترسی شما برای ورود به سامانه توسط ادمین محدود شده است');
          }


          if (Hash::check($request->password, $user->password)){
            Auth::login($user);
            return redirect()->route('admin.index');
          }else{
            return back()->with('message','نام کاربری یا گذرواژه اشتباه است');
          }
        }else{
          return back()->with('message','نام کاربری یا گذرواژه اشتباه است');
        }

    }



}
