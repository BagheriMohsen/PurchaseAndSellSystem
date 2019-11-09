<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $cities = City::latest()->paginate(10);
        return view('Admin.City&State.cities',compact('cities'));
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
        $request->validate([
            'name'  =>  'required | unique:cities'
        ],[
            'name.required' =>  'شهر را وارد نکردید',
            'name.unique'   =>  'این شهر قبلا ثبت شده است'
        ]);

          City::create([
            'name' => $request->name
          ]);
          $message  =   'شهر '.$request->name.' ثبت شد';
          return redirect()->route('cities.index')->with('message',$message);


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
        $request->validate([
            'name'  =>  'required | unique:cities'
        ],[
            'name.required' =>  'شهر را وارد نکردید',
            'name.unique'   =>  'این شهر قبلا ثبت شده است'
        ]);
        
        $city = City::findOrFail($id);
        $cityName = $city->name;
        $city->update([
          'name'  =>  $request->name
        ]);
        $message = 'نام شهر'.' '.$cityName.' '.' به شهر '.$request->name.' تغییر پیدا کرد';
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
        $message = 'شهر '.$cityName.' با موفقیت حذف شد';
        return redirect()->route('cities.index')->with('message',$message);
    }
}
