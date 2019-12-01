<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::latest()->paginate(10);
        return view('Admin.City&State.states',compact('states'));
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
            'name.required' =>  'استان را وارد نکردید',
            'name.unique'   =>  'این استان قبلا ثبت شده است'
        ]);

          State::create([
            'name' => $request->name
          ]);
          $message  =   'استان '.$request->name.' ثبت شد';
          return redirect()->route('states.index')->with('message',$message);


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
            'name.required' =>  'استان را وارد نکردید',
            'name.unique'   =>  'این استان قبلا ثبت شده است'
        ]);
        
        $state = State::findOrFail($id);
        $stateName = $city->name;
        $state->update([
          'name'  =>  $request->name
        ]);
        $message = 'نام استان'.' '.$cityName.' '.' به استان '.$request->name.' تغییر پیدا کرد';
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
        $message = 'استان '.$stateName.' با موفقیت حذف شد';
        return redirect()->route('states.index')->with('message',$message);
    }

    public function AllStatesAndCitiesName(){
        $states = State::with(array('cities'=>function($query){
            $query->select('id','state_id','name');
        }))->get();
        return Response()->json($states,200,[],JSON_UNESCAPED_UNICODE);
    }

}
