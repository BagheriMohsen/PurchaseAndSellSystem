<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::latest()->get();
        $states = State::latest()->paginate(10);
        return view('Admin.City&State.states',compact('states','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = State::where([
          ['name','=',$request->name],
          ['city_id','=',$request->city]
        ])->exists();

        if($status != true){
          State::create([
            'name'    =>  $request->name,
            'city_id' =>  $request->city
          ]);
          $message  = ' استان ';
          $message .= $request->name;
          $message .= ' با موفقیت ثبت شد ';
          return redirect()->route('states.index')->with('message',$message);
        }else{
          $message   = ' استان ';
          $message  .= $request->name;
          $message  .= ' قبلا برای همین شهر ثبت شده است';
          return redirect()->route('states.index')->with('error',$message);
        }

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
        $state = State::findOrFail($id);
        $state->update([
          'name'  =>  $request->name,
          'city_id'=> $request->city
        ]);
          $message  = ' استان ';
          $message .= $request->name;
          $message .= ' با موفقیت به روز رسانی شد ';
        return redirect()->route('states.index')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $stateName = $state->name;
        State::destroy($id);
          $message  = ' استان ';
          $message .= $stateName;
          $message .= ' با موفقیت از بین لیست استانها حذف شد ';
        return redirect()->route('states.index')->with('message',$message);
    }
}
