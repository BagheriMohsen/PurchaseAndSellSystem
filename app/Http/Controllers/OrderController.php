<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $products   = 'App\Product'::latest()->get();
        
        $cities     = 'App\City'::latest()->get();
        $states     = 'App\State'::latest()->get();
        return view('Admin.Order.order-create',compact('cities','states','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'city_id'       =>      $request->city,
            'state_id'      =>      $request->state,
            'mobile'        =>      $request->mobile,
            'telephone'     =>      $request->telephone,
            'fullName'      =>      $request->fullName,
            'paymentMethod' =>      $request->paymentMethod,
            'sendCost'      =>      $request->sendCost,
            'prePrice'      =>      $request->prePrice,
            'checkPrice'    =>      $request->checkPrice,
            'status'        =>      $request->status,
            'description'   =>      $request->description,
            'postalCode'    =>      $request->postalCode,
            'address'       =>      $request->address,
            'HBD_Date'      =>      $request->HBD_Date
        ]);
        $order->sync($request->category);
        return back();
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
        //
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
    /*
    |--------------------------------------------------------------------------
    | Agent Order List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderList(){
        return view('Admin.Order.Agent.orders-index');
    }
}
