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
    /*
    |--------------------------------------------------------------------------
    | Product List 
    |--------------------------------------------------------------------------
    |*/
    public function ProductList(){
        $products = 'App\Product'::with('types')->get();
        return Response()->json($products,200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Exist In State?
    |--------------------------------------------------------------------------
    |*/
    public function AgentExistInState($StateName){
        $state = 'App\State'::where('name',$StateName)->get()->first();
        if($state != null){
            $user = 'App\User'::where('state_id',$state->id)->Role(['agent','agentChief'])->get();
        
            if($user->toArray() !== false){
                $message = 'سیستم ارسال در این شهر دارای نماینده است';
                return Response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
            }else{
                $message = 'سیستم ارسال در این شهر دارای نماینده نمیباشد.این ارسال توسط پست ارسال خواهد شد';
                return Response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
            }
        }else{
            $message = 'خطای سیستم:شهری به این اسم وجود ندارد';
            return Response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
        }
    }

    
}
