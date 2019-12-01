<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use PDF;
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
        return view('Admin.Order.Seller.order-create',compact('cities','states','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*###################IF###################*/
            $city = 'App\City'::where('id',$request->city_id)->first();
            
            // Find Agent In This City if agent send auto is not null
            $userSendAuto = 'App\User'::where([
                ['city_id','=',$city->id],
                ['sendAuto','!=',Null]
            ])->first();
            // if find agent send auto not null
            if($userSendAuto != null){
                $agent_id = $userSendAuto->id;
                $followUpManager_id = null;
            }else{
                $agent_id = null;
                $state = 'App\State'::where('id',$city->state->id)->first();
                $followUpManager_id = $state->followUpManager;

                if($followUpManager_id == null){
                    $user = 'App\User'::role('followUpManager')->first();
                    $followUpManager_id = $user->id;
                }
            }
        /*##################ENDIF##################*/
        $trackingCode = uniqid();
        $order = Order::create([
            'city_id'           =>      $request->city_id,
            'state_id'          =>      $request->state_id,
            'agent_id'          =>      $agent_id,
            'followUpManager_id'=>      $followUpManager_id,
            'seller_id'         =>      auth()->user()->id,
            'status'            =>      7,
            'lastStatus'        =>      1,
            'trackingCode'      =>      $trackingCode,
            'mobile'            =>      $request->mobile,
            'telephone'         =>      $request->telephone,
            'fullName'          =>      $request->fullName,
            'paymentMethod'     =>      $request->paymentMethod,
            'shippingCost'      =>      $request->shippingCost,
            'prePayment'        =>      $request->prePayment,
            'cashPrice'         =>      $request->cashPrice,
            'chequePrice'       =>      $request->chequePrice,
            'instant'           =>      $request->instant,
            'sellerDescription' =>      $request->sellerDescription,
            'postalCode'        =>      $request->postalCode,
            'address'           =>      $request->address,
            'HBD_Date'          =>      $request->HBD_Date
        ]);
        $items = $request->orderArray;
        foreach($items as $item){
            'App\OrderProduct'::create([
                'order_id'      =>  $order->id,
                'product_id'    =>  $item['product_id'],
                'count'         =>  $item['count'],
                'off'           =>  $item['off'],
                'product_type'  =>  $item['type']
            ]);
        }
        return Response()->json('سفارش با موفقیت ثبت شد',200,[],JSON_UNESCAPED_UNICODE);
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
    public function AgentOrderLists(){
        $bottom_statuses = 'App\OrderStatus'::skip(10)->take(4)->get();
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where(['agent_id'=>$user->id,'status'=>7])->latest()->get();
        return view('Admin.Order.Agent.agent-orders',compact('orders','bottom_statuses'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Collected list
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderCollectedlist(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where(['agent_id'=>$user->id,'status'=>1])->latest()->get();
        return view('Admin.Order.Agent.agent-orders-collected',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Canceled List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderCanceledList(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where(['agent_id'=>$user->id,'status'=>1])->latest()->get();
        return view('Admin.Order.Agent.agent-orders-canceled',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Suspended List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderSuspendedList(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where(['agent_id'=>$user->id,'status'=>1])->latest()->get();
        return view('Admin.Order.Agent.agent-orders-suspended',compact('orders'));
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
    public function AgentExistInState($CityName){
        
        $city = 'App\City'::where('name',$CityName)->exists();
   
        if($city == True){
            $city = 'App\City'::where('name',$CityName)->get()->first();
          
            $user = 'App\User'::where('city_id',$city->id)->Role(['agent','agentChief'])->get();
           
            if($user->toArray() != false){
                $result = ['message'=>'سیستم ارسال در این شهر دارای نماینده است','state'=>'2'];
                return Response()->json($result,200,[],JSON_UNESCAPED_UNICODE,$city);
            }else{
                $result = ['message'=>'سیستم ارسال در این شهر دارای نماینده نمیباشد.این ارسال توسط پست ارسال خواهد شد','state'=>'1'];
                return Response()->json($result,200,[],JSON_UNESCAPED_UNICODE,$city);
            }
        }else{
            $result = ['message'=>'خطای سیستم:شهری به این اسم وجود ندارد','state'=>'0'];
            return Response()->json($result,200,[],JSON_UNESCAPED_UNICODE,$city);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Seller Orders Lists
    |--------------------------------------------------------------------------
    |*/
    public function sellerOrdersLists(){
        $orders = Order::latest()->paginate(10);
        return view('Admin.Order.Seller.seller-orders',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Change Order Status
    |--------------------------------------------------------------------------
    |*/
    public function AgentChangeOrderStatus(){

        return response('ok');
    }
    /*
    |--------------------------------------------------------------------------
    | Factor
    |--------------------------------------------------------------------------
    |*/
    public function Factor(){
        $pdf = PDF::loadView('Admin.Order.Factor');
        return $pdf->download('invoice.pdf');
    }
    /*
    |--------------------------------------------------------------------------
    | Seller No Action Orders
    |--------------------------------------------------------------------------
    |*/
    public function sellerNoActionOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where(['seller_id'=>$user->id,'status'=>1,'agent_id'=>null])->latest()->get();
        return view('Admin.Order.Seller.seller-noAction-orders',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Unverified Order List
    |--------------------------------------------------------------------------
    |*/
    public function UnverifiedOrderList(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            'followUpManager_id'=>$user->id,
            'status'=>1,
            'agent_id'=>null
            ])->latest()->get();
        return view('Admin.Order.FollowUpManager.unverified-orders',compact('orders'));
    }
    
}
