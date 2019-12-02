<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use PDF;
use Carbon\Carbon;
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
        $bottom_statuses = 'App\OrderStatus'::skip(9)->take(5)->get();
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['status','=',7],// Waiting For Delivary
            ['agent_id','=',$user->id]
        ])->latest()->get();
        return view('Admin.Order.Agent.agent-orders',compact('orders','bottom_statuses'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Collected list
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderCollectedlist(){
        $bottom_statuses = 'App\OrderStatus'::skip(9)->take(5)->get();
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
                ['status','=',10],//Collected in City
                ['agent_id','=',$user->id]
            ])
            ->orWhere([
                ['status','=',11],//Collected in Suburbs
                ['agent_id','=',$user->id]
            ])
            ->orWhere([
                ['status','=',12],//Collected in Village
                ['agent_id','=',$user->id]
            ])
            ->latest()->get();
            
        return view('Admin.Order.Agent.agent-orders-collected',compact(
            'orders',
            'bottom_statuses',
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Canceled List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderCanceledList(){
        $bottom_statuses = 'App\OrderStatus'::skip(9)->take(5)->get();
        $CustomerCancelled = 13;//Customer cancelled
        $CustomerFinalCancelled = 16;//Customer Final Cancelled
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['status','=',13],//Customer cancelled
            ['agent_id','=',$user->id]
        ])
        ->orWhere([
            ['status','=',16],//Customer Final Cancelled
            ['agent_id','=',$user->id]
        ])
        ->latest()->get();
        return view('Admin.Order.Agent.agent-orders-canceled',compact(
            'orders',
            'bottom_statuses',
            'CustomerCancelled',
            'CustomerFinalCancelled'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Order Suspended List
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderSuspendedList(){
        $bottom_statuses = 'App\OrderStatus'::skip(9)->take(5)->get();
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $Orders_Status = 14;// Order Suspended
        $orders = Order::where([
            ['status','=',14],// Order Suspended
            ['agent_id','=',$user->id]
        ])->latest()->get();
        return view('Admin.Order.Agent.agent-orders-suspended',compact(
            'orders',
            'bottom_statuses',
            'Orders_Status'
        ));
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
    public function AgentChangeOrderStatus(Request $request){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $items = $request->orderNumbers;
        foreach($items as $item){

            
            if($item['statue'] == 10 || $item['statue'] == 11 || $item['statue'] == 12){
                
                $order = Order::findOrFail($item['id']);
              
                    foreach($order->products as $order_product){
                        
                            $status = 'App\Storage'::where([
                                ['agent_id','=',$user->id],
                                ['product_id','=',$order_product->product_id],
                                ['number','<',$order_product->count]
                            ])->exists();
                           
                            //IF Product is not exists in agent storage
<<<<<<< HEAD
                            if($status == true){
                                
                                $message = ' کالای  '.$order_product->product->name.' در انبار به تعداد مورد نیاز موجود نیست ';
                                return response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
=======
                            if($status == True){
                                $result = ['message' => ' کالای  '.$order_product->product->name.' در انبار به تعداد مورد نیاز موجود نیست ','status' => 0];
                                return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
>>>>>>> 18fe72ad32ad41fb6c4933dc9c381328c8e6a63b
                        
                            //IF Product is exists in agent storage
                            }else{

                                $storage_status = 'App\Storage'::where([
                                    ['agent_id','=',$user->id],
                                    ['product_id','=',$order_product->product_id]
                                ])->exists();
                                // Product Not Found
                                if($storage_status != true){
                                    $message = ' کالای  '.$order_product->product->name.' در انبار وجود ندارد ';
                                    return response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
                                }

                                $storage = 'App\Storage'::where([
                                    ['agent_id','=',$user->id],
                                    ['product_id','=',$order_product->product_id]
                                ])->firstOrFail();

                                // Change Order Status To Collected 
                                $order = 'App\Order'::findOrFail($item['id']);
                                $order->update(['status'=>$item['statue']]);
                                // Discount count of product in Agent Storage
                                $number = $storage->number - $order_product->count;
                                $storage->update(['number'=>$number]);

                                // Create OutPut store room for Agent
                                'App\StoreRoom'::create([
                                    'user_id'           =>  $user->id,
                                    'storage_id'        =>  $storage->id,
                                    'sender_id'         =>  $user->id,
                                    'customerName'      =>  $order->fullName,
                                    'product_id'        =>  $order_product->product_id,
                                    'transport_id'      =>  null,
                                    'number'            =>  $order_product->count,
                                    'description'       =>  'تحویل به مشتری',
                                    'status'            =>  'به مشتری تحویل داده شد',
                                    'in_out'            =>  13,
                                    'out_date'          =>  Carbon::now()
                                ]);
                            }


               }     


            //Other order Statuses
            }else{
                $order = 'App\Order'::findOrFail($item['id']);
                $order->update(['status'=>$item['statue']]);
            }

            
        }
        return response()->json(['message' => 'موفقیت آمیز بود','status' => 1]);
        
    }
    /*
    |--------------------------------------------------------------------------
    | Factor
    |--------------------------------------------------------------------------
    |*/
    public function Factor($id){
        $order = 'App\Order'::findOrFail($id);
        return view('Admin.Order.Factor',compact('order'));
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
        $agents = 'App\User'::Role('agent')->latest()->get();
        $orders = Order::where([
            ['followUpManager_id','=',$user->id],
            ['status','=',3],
            ['agent_id','=',null]
            ])->latest()->get();
        return view('Admin.Order.FollowUpManager.unverified-orders',compact(
            'orders',
            'agents',
            'user'
        ));
    }

    public function sellerOrderCallBack(){
     
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['seller_id','=',$user->id],
            ['status','=',13],//Customer Cancelled
            ])->latest()->get();
        
        return view('Admin.Order.Seller.order-callback',compact(
            'orders',
        ));
    }
    
}
