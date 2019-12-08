<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
class CityController extends Controller
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
        return view('Admin.City&State.cities',compact('states','cities'));
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
     
        $status = City::where([
          ['name','=',$request->name],
          ['state_id','=',$request->state]
        ])->exists();
          
        if($status != true){
          City::create([
            'name'    =>  $request->name,
            'state_id' =>  $request->state
          ]);
          $message  = ' شهر ';
          $message .= $request->name;
          $message .= ' با موفقیت ثبت شد ';
          return redirect()->route('cities.index')->with('message',$message);
        }else{
          $message   = ' شهر ';
          $message  .= $request->name;
          $message  .= ' قبلا برای همین استان ثبت شده است';
          return redirect()->route('cities.index')->with('error',$message);
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
        $city = City::findOrFail($id);
        $city->update([
          'name'  =>  $request->name,
          'state_id'=> $request->state
        ]);
          $message  = ' شهر ';
          $message .= $request->name;
          $message .= ' با موفقیت به روز رسانی شد ';
        return redirect()->route('cities.index')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $cityName = $city->name;
        City::destroy($id);
          $message  = ' شهر ';
          $message .= $cityName;
          $message .= ' با موفقیت از بین لیست شهرها حذف شد ';
        return redirect()->route('cities.index')->with('message',$message);
    }

    public function search(Request $request){

      $name = $request->cityName;
     
      $cities = City::query()
      ->when($name,function($query,$name){
          return $query
          ->where('name','LIKE',"%{$name}%");
      })
      ->latest()->paginate(10);

      $states = State::latest()->paginate(10);
      return view('Admin.City&State.cities',compact('states','cities'));
    }
}
