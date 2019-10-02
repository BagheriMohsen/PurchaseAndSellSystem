<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('Admin.users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles  = 'App\Role'::latest()->get();
        $cities = 'App\City'::latest()->get();
        return view('Admin/users-create',compact('cities','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         User::create([
          'name'          =>  $request->name,
          'family'        =>  $request->family,
          'role_id'       =>  $request->role,
          'sex'           =>  $request->sex,
          'username'      =>  $request->username,
          'password'      =>  Hash::make($request->password),
          'mobile'        =>  $request->mobile,
          'status'        =>  $request->status,
          'state_id'      =>  $request->state,
          'address'       =>  $request->address,
          'uploadCS'      =>  $request->uploadCS,
          'level'         =>  $request->level,
          'sendAuto'      =>  $request->sendAuto,
          'reciveAuto'    =>  $request->reciveAuto,
          'callCenter'    =>  $request->callCenter,
          'agent_id'      =>  $request->agent_id,
          'porsantSeller' =>  $request->porsantSeller,
          'percent'       =>  $request->percent,
          'calType'       =>  $request->calType,
          'locallyPrice'  =>  $request->locally,
          'internalPrice' =>  $request->internal,
          'villagePrice'  =>  $request->village
        ]);
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
      $roles  = 'App\Role'::latest()->get();
      $cities = 'App\City'::latest()->get();
      $user = User::findOrFail($id);
      return view('Admin/users-edit',compact('user','roles','cities'));
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
       'name'          =>  $request->name,
       'family'        =>  $request->family,
       'role_id'       =>  $request->role,
       'sex'           =>  $request->sex,
       'username'      =>  $request->username,
       'password'      =>  Hash::make($request->password),
       'mobile'        =>  $request->mobile,
       'status'        =>  $request->status,
       'state_id'      =>  $request->state,
       'address'       =>  $request->address,
       'uploadCS'      =>  $request->uploadCS,
       'level'         =>  $request->level,
       'sendAuto'      =>  $request->sendAuto,
       'reciveAuto'    =>  $request->reciveAuto,
       'callCenter'    =>  $request->callCenter,
       'agent_id'      =>  $request->agent_id,
       'porsantSeller' =>  $request->porsantSeller,
       'percent'       =>  $request->percent,
       'calType'       =>  $request->calType,
       'locallyPrice'  =>  $request->locally,
       'internalPrice' =>  $request->internal,
       'villagePrice'  =>  $request->village
     ]);
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
        //
    }
}
