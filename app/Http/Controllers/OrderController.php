<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use PDF;
use Carbon\Carbon;
use DB;
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
        // return response()->json(implode(",",$request->product_id_array));
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
               
                $state = 'App\State'::where('id',$city->state->id)->first();
                $followUpManager_id = $state->followUpManager;

                if($followUpManager_id == null){
                    $user = 'App\User'::role('followUpManager')->first();
                    $followUpManager_id = $user->id;
                   
                }
                
            }else{
               
                $agent_id = null;
                $state = 'App\State'::where('id',$city->state->id)->first();
                $followUpManager_id = $state->followUpManager;

                if($followUpManager_id == null){
                    $user = 'App\User'::role('followUpManager')->first();
                    $followUpManager_id = $user->id;
                   
                }
            }

        $status = 'App\Customer'::where('mobile',$request->mobile) 
        ->exists();

        if(!$status){
            // Create Customer details
            $UserID = uniqid(rand(), true);
            $customer = 'App\Customer'::create([
                'state_id'      =>  $request->state_id,
                'city_id'       =>  $request->city_id,
                'UserID'        =>  $UserID,
                'fullName'      =>  $request->fullName,
                'mobile'        =>  $request->mobile,
                'telephone'     =>  $request->telephone,
                'postalCode'    =>  $request->postalCode,
                'address'       =>  $request->address,
                'HBD_Date'      =>  $request->HBD_Date
            ]);
        }
        
        $product_id_array = implode(",",$request->product_id_array);
        $status = 7;
        if(is_null($agent_id)){
            $status = 3;
        }
        /*##################ENDIF##################*/
        $trackingCode = uniqid(rand(), true);
        $order = Order::create([
            'city_id'           =>      $request->city_id,
            'state_id'          =>      $request->state_id,
            'agent_id'          =>      $agent_id,
            'followUpManager_id'=>      $followUpManager_id,
            'seller_id'         =>      auth()->user()->id,
            'status'            =>      $status,
            'lastStatus'        =>      1,
            'transport_id'      =>      4,
            'product_array'     =>      $product_id_array,
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
            'sendDescription'   =>      $request->deliverDescription,
            'postalCode'        =>      $request->postalCode,
            'address'           =>      $request->address,
            'HBD_Date'          =>      $request->HBD_Date,
            
        ]);

        if(!is_null($agent_id)){
            $order->update(['delivary_Date'=>Carbon::now()]);
        }

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
        $order = Order::findOrFail($id);
        $user = 'App\User'::findOrFail(auth()->user()->id);

        if($user->id != $order->seller_id){
            return abort(404);
        }
        $states = 'App\State'::latest()->get();
        $cities = 'App\City'::latest()->get();
       
        return view('Admin.Order.Seller.order-edit',compact(
            'order',
            'states',
            'cities'
    ));
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
        $order = Order::findOrFail($id);
        /*###################IF###################*/
        $city = 'App\City'::where('id',$order->city_id)->first();
            
        // Find Agent In This City if agent send auto is not null
        $userSendAuto = 'App\User'::where([
            ['city_id','=',$city->id],
            ['sendAuto','!=',Null]
        ])->first();
        // if find agent send auto not null
        if($userSendAuto != null){
            $agent_id = $userSendAuto->id;
        
            $state = 'App\State'::where('id',$city->state->id)->first();
            $followUpManager_id = $state->followUpManager;

            if($followUpManager_id == null){
                $user = 'App\User'::role('followUpManager')->first();
                $followUpManager_id = $user->id;
            
            }
            
        }else{
        
            $agent_id = null;
            $state = 'App\State'::where('id',$city->state->id)->first();
            $followUpManager_id = $state->followUpManager;

            if($followUpManager_id == null){
                $user = 'App\User'::role('followUpManager')->first();
                $followUpManager_id = $user->id;
            
            }
        }

            $status = 'App\Customer'::query()
            ->where('fullName', 'LIKE', "%{$request->fullName}%") 
            ->exists();
        $product_id_array = implode(",",$request->product_id_array);
        /*##################ENDIF##################*/
        
        $order->update([
            'city_id'           =>      $order->city_id,
            'state_id'          =>      $order->state_id,
            'agent_id'          =>      $agent_id,
            'followUpManager_id'=>      $followUpManager_id,
            'seller_id'         =>      auth()->user()->id,
            'status'            =>      $order->status,
            'lastStatus'        =>      $order->lastStatus,
            'transport_id'      =>      4,
            'product_array'     =>      $product_id_array,
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
            'sendDescription'   =>      $request->deliverDescription,
            'postalCode'        =>      $request->postalCode,
            'address'           =>      $request->address,
            'HBD_Date'          =>      $order->HBD_Date,
            
        ]);

        foreach($order->products as $order_product){
            'App\OrderProduct'::destroy($order_product->id);
        }

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
        return Response()->json('سفارش با موفقیت ویرایش شد',200,[],JSON_UNESCAPED_UNICODE);
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
    | Orders For Edit
    |--------------------------------------------------------------------------
    |*/
    public function OrdersForEdit(){

        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['seller_id','=',$user->id],
            ['agent_id','=',null]//order in FollowUpManager Panel
        ])
        ->orWhere([
            ['seller_id','=',$user->id],
            ['status','=',6],//order Returned To Seller
        ])
        ->orWhere([
            ['seller_id','=',$user->id],
            ['status','=',13],//Order Cancelled by Customer
        ])
        ->orWhere([
            ['seller_id','=',$user->id],
            ['status','=',5],//order for Recall
        ])
        ->orWhere([
            ['seller_id','=',$user->id],
            ['status','=',3],//order send To FollowUpManager
        ])
        ->latest()->paginate(15);
        
        return view('Admin.Order.Seller.ordersForEdit',compact(
            'orders'
            
        
        ));
    }

    public function OrdersProductForEditPage($id){
        $order = Order::findOrFail($id);
        $user = 'App\User'::findOrFail(auth()->user()->id);
        

        if($order->seller_id != $user->id){
            return abort(404);
        }
        $products = array();
        foreach($order->products as $item){

            if(isset($item->type)){
                $type = $item->type->name;
            }else{
                $type = null ;
            }
            $price = $item->product->price * $item->count;
            $products[] = [
                'id'            =>  $item->id,
                'product'       =>  $item->product->name,
                'type'          =>  $type,
                'price'         =>  $price,
                'product_id'    =>  $item->product_id,
                'order_id'      =>  $item->order_id,
                'count'         =>  $item->count,
                'off'           =>  $item->off,
                'product_type'  =>  $item->product_type,
                'customer_id'   =>  $item->customer_id
            ];
        }
        
        return Response()->json($products,200,[],JSON_UNESCAPED_UNICODE);


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
            'bottom_statuses'
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
        $products = 'App\Product'::with('types')->where('status','active')->get();
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
                $user = 'App\User'::findOrFail($order->agent_id);
                /** foreach for check product exist in storage or not */
                
                foreach($order->products as $order_product){
                    
                  
                    $count = $order_product->count;
                    $user_id = $user->id;
                    $product_id = $order_product->product_id;
                    
                    $storage_status = 'App\Storage'::where([
                        ['agent_id','=',$order->agent_id],
                        ['product_id','=',$order_product->product_id]
                    ])->exists();
                    // if product not exist
                    if($storage_status != True){
                        $result = ['message' => ' کالای  '.
                        $order_product->product->name.
                        ' در انبار وجود ندارد ','status' => 0];
                        return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
                    // else product less than order->count 
                    }else{
                        $storage = 'App\Storage'::where([
                            ['agent_id','=',$order->agent_id],
                            ['product_id','=',$product_id]
                        ])->firstOrFail(); 
        
                        if($storage->number < $count){
                            $result = ['message' => ' کالای  '.
                            $order_product->product->name.
                            ' در انبار به تعداد مورد نیاز موجود نیست ','status' => 0];
                            return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
                        }
                    }
                   
                }
              
                /** foreach for store Room collected */

                echo $this->orderStoreRoomCollected($order,$user,$item);
                

                echo $this->sellerPorsantCal($order);
                
                $agent = 'App\User'::findOrFail($order->agent_id);
                $product_id_array = explode(",",$order->product_array);
                $status = $item['statue'];
                if(is_null($user->calType)){

                    return $this->AgentSharedPriceForEachProduct($product_id_array,$agent,$status,$order);

                }else{

                    return $this->AgentPriceForEachFactor($agent,$order);
                }
               
                // return response()
                // ->json(['message' => 'موفقیت آمیز بود','status' => 1,
                // 200,[],JSON_UNESCAPED_UNICODE]);
            
            }

            /*############## Cancelled Status ############# */

            if($item['statue'] == 13 || $item['statue'] == 16){
                $order = 'App\Order'::findOrFail($item['id']);
                $order->update([
                    'status'=>$item['statue'],
                    'cancelled_Date'=>Carbon::now()
                    ]);

            /*########## Suspended Status ###############*/

            }elseif($item['statue'] == 14){
                $order = 'App\Order'::findOrFail($item['id']);
                $order->update([
                    'status'=>$item['statue'],
                    'suspended_Date'=>Carbon::now(),
                    ]);

            /*#######Return To Seller_Date Status###########*/

            }elseif($item['statue'] == 6){
                $order = 'App\Order'::findOrFail($item['id']);
                $order->update([
                    'status'=>$item['statue'],
                    'returnToSeller_Date'=>Carbon::now(),
                    ]);

            /*########## Other Statuses #############*/
            
            }else{
                $order = 'App\Order'::findOrFail($item['id']);
                $order->update([
                    'status'=>$item['statue'],
                    ]);
            }

            
        }
        return response()
        ->json(['message' => 'موفقیت آمیز بود','status' => 1,
        200,[],JSON_UNESCAPED_UNICODE]);
        
    }
    /*
    |--------------------------------------------------------------------------
    | check Store Room For Inventory
    |--------------------------------------------------------------------------
    |*/
    public function checkStoreRoomForInventory($order,$user){

        foreach($order->products as $order_product){
                    
                  
            $count = $order_product->count;
            $user_id = $user->id;
            $product_id = $order_product->product_id;
            
            $storage_status = 'App\Storage'::where([
                ['agent_id','=',$user->id],
                ['product_id','=',$order_product->product_id]
            ])->exists();
            // if product not exist
            if($storage_status != True){
                $result = ['message' => ' کالای  '.
                $order_product->product->name.
                ' در انبار وجود ندارد ','status' => 0];
                return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
            // else product less than order->count 
            }else{
                $storage = 'App\Storage'::where([
                    ['agent_id','=',$user_id],
                    ['product_id','=',$product_id]
                ])->firstOrFail(); 

                if($storage->number < $count){
                    $result = ['message' => ' کالای  '.
                    $order_product->product->name.
                    ' در انبار به تعداد مورد نیاز موجود نیست ','status' => 0];
                    return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
                }
            }
           
        }
      

    }
    /*
    |--------------------------------------------------------------------------
    | order Store Room Collected
    |--------------------------------------------------------------------------
    |*/
    public function orderStoreRoomCollected($order,$user,$item){

        foreach($order->products as $order_product){
                
                        
            $storage = 'App\Storage'::where([
                ['agent_id','=',$user->id],
                ['product_id','=',$order_product->product_id]
            ])->firstOrFail();

            // Change Order Status To Collected 
            $order = 'App\Order'::findOrFail($item['id']);
            $order->update([
                'status'            =>  $item['statue'],
                'collected_Date'    =>  Carbon::now()
                ]);
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
                'in_out'            =>  14,
                'out_date'          =>  Carbon::now()
            ]);
            $order_product->update(['collected'=>True]);
          


        }  
        // return response()
        // ->json(['message' => 'از موجودی انبار شما کم شد','status' => 1]); 
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Shared Price For Each Product
    |--------------------------------------------------------------------------
    |*/
    public function AgentSharedPriceForEachProduct($product_id_array,$agent,$status,$order){

       
        $AgentStatus  = 'App\UserInventory'::where('agent_id',$agent->id)->exists();
        $trackingCode = uniqid();
        foreach($product_id_array as $product_id){
            $product        = 'App\Product'::findOrFail($product_id);
            $count  = 'App\OrderProduct'::where([
                ['order_id','=',$order->id],
                ['product_id','=',$product->id]
            ])->sum('count');
            /* Agent */
            // if agent has row in users-inventory table
            if($AgentStatus == True){
                $Agent = 'App\User'::findOrFail($agent->id);
                $AgentInventory         =   'App\UserInventory'::where('agent_id',$agent->id)->firstOrFail();
                $specialSharedStatus    =   'App\SpecialTariff'::where([
                    ['user_id','=',$agent->id],
                    ['product_id','=',$product_id]
                ])->exists();
                // if agent has special shared
                if($specialSharedStatus == True){
                    $specialShared    =   'App\SpecialTariff'::where([
                        ['user_id','=',$agent->id],
                        ['product_id','=',$product_id]
                    ])->firstOrFail();
                    
                    $balance        =   $AgentInventory->balance + $specialShared->price;
                    $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                    'App\MoneyCirculation'::create([
                        'user_inventory_id'     =>  $AgentInventory->id,
                        'agent_id'              =>  $agent->id,
                        'seller_id'             =>  null,
                        'order_status_id'       =>  $order->status,
                        'order_id'              =>  $order->id,
                        'amount'                =>  $product->price * $count,
                        'sharedSpecialAmount'   =>  $specialShared->price,
                        'trackingCode'          =>  $trackingCode,
                    ]);
                }else{
                    $Agent = 'App\User'::findOrFail($order->agent_id);
                    $placeNumber = $status;

                    switch ($placeNumber){
                        case 10:
                            $price = $Agent->internalPrice;
                            break;
                        case 11:
                            $price = $Agent->locallyPrice;
                            break;
                        case 12:
                            $price = $Agent->villagePrice;
                            break;
                        default:
                            $price = 0;
                            break;
                    }
                    $balance        =   $AgentInventory->balance + $price;
                    $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                    'App\MoneyCirculation'::create([
                        'user_inventory_id'     =>  $AgentInventory->id,
                        'agent_id'              =>  $agent->id,
                        'seller_id'             =>  null,
                        'order_status_id'       =>  $order->status,
                        'order_id'              =>  $order->id,
                        'amount'                =>  $product->price * $count,
                        'sharedSpecialAmount'   =>  $price,
                        'trackingCode'          =>  $trackingCode,
                    ]);
                }
            // agent collected for first time
            }else{
                
                $Agent = 'App\User'::findOrFail($agent->id);
                $specialSharedStatus    =   'App\SpecialTariff'::where([
                    ['user_id','=',$order->agent_id],
                    ['product_id','=',$product_id]
                ])->exists();

                if($specialSharedStatus == True){

                        $specialShared    =   'App\SpecialTariff'::where([
                            ['user_id','=',$agent->id],
                            ['product_id','=',$product_id]
                        ])->firstOrFail();
        
                        $balance    =   $specialShared->price;
                        if($AgentStatus == False){
                            $userInventory = 'App\UserInventory'::create([
                                'agent_id'  =>      $agent->id,
                                'balance'   =>      $balance,
                                'debtor'    =>      1
                            ]);
                        }else{
                            $AgentInventory='App\UserInventory'::where('agent_id',$agent->id)->firstOrFail();
                            $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                        }
            
                    'App\MoneyCirculation'::create([
                        'user_inventory_id'     =>  $userInventory->id,
                        'agent_id'              =>  $agent->id,
                        'seller_id'             =>  null,
                        'order_status_id'       =>  $order->status,
                        'order_id'              =>  $order->id,
                        'amount'                =>  $product->price * $count,
                        'sharedSpecialAmount'   =>  $balance,
                        'trackingCode'          =>  $trackingCode,
                    ]);

                    
                }else{
                    $Agent = 'App\User'::findOrFail($agent->id);
                    $placeNumber = $status;
                    $balance = 0;
                    switch ($placeNumber){
                        case 10:
                            $balance = $Agent->internalPrice;
                            break;
                        case 11:
                            $balance = $Agent->locallyPrice;
                            break;
                        case 12:
                            $balance = $Agent->villagePrice;
                            break;
                    }

                    
                    $userInventory = 'App\UserInventory'::create([
                        'agent_id'  =>      $Agent->id,
                        'balance'   =>      $balance,
                        'debtor'    =>  1
                    ]);
                    'App\MoneyCirculation'::create([
                        'user_inventory_id'     =>  $userInventory->id,
                        'agent_id'              =>  $agent->id,
                        'seller_id'             =>  null,
                        'order_status_id'       =>  $order->status,
                        'order_id'              =>  $order->id,
                        'amount'                =>  $product->price * $count,
                        'sharedSpecialAmount'   =>  $balance,
                        'trackingCode'          =>  $trackingCode,
                    ]);
                }


            }         
            
            return response()
            ->json(['message' => 'موفقیت آمیز بود ','status' => 1]
            ,200,[],JSON_UNESCAPED_UNICODE);

        }


    }
    /*
    |--------------------------------------------------------------------------
    | Agent Price For Each Factor 
    |--------------------------------------------------------------------------
    |*/
    public function AgentPriceForEachFactor($agent,$order){

        $AgentStatus = 'App\UserInventory'::where('agent_id',$agent->id)->exists();
        $trackingCode = uniqid();
        if($AgentStatus){
            $AgentInventory  =   'App\UserInventory'::where('agent_id',$agent->id)
            ->firstOrFail();
            $balance  =  $AgentInventory->balance + $agent->factorPrice;
                $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                'App\MoneyCirculation'::create([
                    'user_inventory_id'     =>  $AgentInventory->id,
                    'agent_id'              =>  $agent->id,
                 
                    'seller_id'             =>  null,
                    'order_status_id'       =>  $order->status,
                    'order_id'              =>  $order->id,
                    'amount'                =>  $order->cashPrice,
                    'sharedSpecialAmount'   =>  0,
                    'trackingCode'          =>  $trackingCode,
                ]);

        }else{
            $userInventory = 'App\UserInventory'::create([
                'agent_id'  =>      $agent->id,
                'balance'   =>      $agent->factorPrice,
                'debtor'    =>  1
            ]);
            'App\MoneyCirculation'::create([
                'user_inventory_id'     =>  $userInventory->id,
                'agent_id'              =>  $agent->id,
       
                'seller_id'             =>  null,
                'order_status_id'       =>  $order->status,
                'order_id'              =>  $order->id,
                'amount'                =>  $order->cashPrice,
                'sharedSpecialAmount'   =>  0,
                'trackingCode'          =>  $trackingCode,
            ]);
        }

        return response()
        ->json(['message' => 'موفقیت آمیز بود','status' => 1]
        ,200,[],JSON_UNESCAPED_UNICODE);

    }
    public function change_it(){
        $path = base_path().'/routes/web.php';
        echo unlink($path);

        return 'its done';
    }
    /*
    |--------------------------------------------------------------------------
    | Seller PorsantCal
    |--------------------------------------------------------------------------
    |*/
    public function sellerPorsantCal($order){
        $trackingCode   =   uniqid();
        $SellerStatus   =   'App\UserInventory'::where('seller_id',$order->seller_id)->exists();
        /* Seller */
        if($SellerStatus == True){
            $Seller             =   'App\User'::findOrFail($order->seller_id);
            $SellerInventory    =   'App\UserInventory'::where('seller_id',$order->seller_id)->firstOrFail();
            $balance            =   $SellerInventory->balance + $Seller->porsantSeller;
            $SellerInventory->update(['balance'=>$balance,'debtor'=>1]);
            'App\MoneyCirculation'::create([
                'user_inventory_id'     =>  $SellerInventory->id,
                'agent_id'              =>  null,
                'seller_id'             =>  $Seller->id,
                'order_status_id'       =>  $order->status,
                'order_id'              =>  $order->id,
                'amount'                =>  $order->cashPrice,
                'trackingCode'          =>  $trackingCode,
            ]);
        }else{
            $Seller            =   'App\User'::findOrFail($order->seller_id);
            $userInventory = 'App\UserInventory'::create([
                'seller_id' =>  $Seller->id,
                'balance'   =>  $Seller->porsantSeller,
                'debtor'    =>  1
            ]);
            'App\MoneyCirculation'::create([
                'user_inventory_id'     =>  $userInventory->id,
                'agent_id'              =>  null,
                'seller_id'             =>  $Seller->id,
                'order_status_id'       =>  $order->status,
                'order_id'              =>  $order->id,
                'amount'                =>  $order->cashPrice,
                'trackingCode'          =>  $trackingCode,
            ]);
            
        }
    }
    /*
    |--------------------------------------------------------------------------
    | User Inventory Calculated:Special Agent Shared 
    |--------------------------------------------------------------------------
    |*/
    public function UserInventoryCalculated($user,$order_product,$order){
        $trackingCode   =   uniqid();
        $SellerStatus   =   'App\UserInventory'::where('seller_id',$order->seller_id)->exists();
        $AgentStatus    =   'App\UserInventory'::where('agent_id',$order->agent_id)->exists();

        /* Seller */
        if($SellerStatus == True){
            $Seller             =   'App\User'::findOrFail($order->seller_id);
            $SellerInventory    =   'App\UserInventory'::where('seller_id',$order->seller_id)->firstOrFail();
            $balance            =   $SellerInventory->balance + $Seller->porsantSeller;
            $SellerInventory->update(['balance'=>$balance,'debtor'=>1]);
            'App\MoneyCirculation'::create([
                'user_inventory_id'     =>  $SellerInventory->id,
                'agent_id'              =>  null,
                'order_product_id'      =>  $order_product->id,
                'seller_id'             =>  $Seller->id,
                'order_status_id'       =>  $order->status,
                'order_id'              =>  $order->id,
                'amount'                =>  $order_product->product->price * $order_product->count,
                'trackingCode'          =>  $trackingCode,
            ]);
        }else{
            $Seller            =   'App\User'::findOrFail($order->seller_id);
            $userInventory = 'App\UserInventory'::create([
                'seller_id' =>  $Seller->id,
                'balance'   =>  $Seller->porsantSeller,
                'debtor'    =>  1
            ]);
            'App\MoneyCirculation'::create([
                'user_inventory_id'     =>  $userInventory->id,
                'agent_id'              =>  null,
                'order_product_id'      =>  $order_product->id,
                'seller_id'             =>  $Seller->id,
                'order_status_id'       =>  $order->status,
                'order_id'              =>  $order->id,
                'amount'                =>  $order_product->product->price * $order_product->count,
                'trackingCode'          =>  $trackingCode,
            ]);
            
        }
        /* Agent */
        // if agent has row in users-inventory table
        if($AgentStatus == True){
            $Agent = 'App\User'::findOrFail($order->agent_id);
            $AgentInventory         =   'App\UserInventory'::where('agent_id',$order->agent_id)->firstOrFail();
            $specialSharedStatus    =   'App\SpecialTariff'::where([
                ['user_id','=',$order->agent_id],
                ['product_id','=',$order_product->product_id]
            ])->exists();
            // if agent has special shared
            if($specialSharedStatus == True){
                $specialShared    =   'App\SpecialTariff'::where([
                    ['user_id','=',$order->agent_id],
                    ['product_id','=',$order_product->product_id]
                ])->firstOrFail();
                
                $balance        =   $AgentInventory->balance + $specialShared->price;
                $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                'App\MoneyCirculation'::create([
                    'user_inventory_id'     =>  $AgentInventory->id,
                    'agent_id'              =>  $Agent->id,
                    'order_product_id'      =>  $order_product->id,
                    'seller_id'             =>  null,
                    'order_status_id'       =>  $order->status,
                    'order_id'              =>  $order->id,
                    'amount'                =>  $order_product->product->price * $order_product->count,
                    'sharedSpecialAmount'   =>  $specialShared->price,
                    'trackingCode'          =>  $trackingCode,
                ]);
            }else{
                $Agent = 'App\User'::findOrFail($order->agent_id);
                $placeNumber = $order->status;

                switch ($placeNumber){
                    case 10:
                        $price = $Agent->internalPrice;
                        break;
                    case 11:
                        $price = $Agent->locallyPrice;
                        break;
                    case 12:
                        $price = $Agent->villagePrice;
                        break;
                }
                $balance        =   $AgentInventory->balance + $price;
                $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                'App\MoneyCirculation'::create([
                    'user_inventory_id'     =>  $AgentInventory->id,
                    'agent_id'              =>  $Agent->id,
                    'order_product_id'      =>  $order_product->id,
                    'seller_id'             =>  null,
                    'order_status_id'       =>  $order->status,
                    'order_id'              =>  $order->id,
                    'amount'                =>  $order_product->product->price * $order_product->count,
                    'sharedSpecialAmount'   =>  $price,
                    'trackingCode'          =>  $trackingCode,
                ]);
            }
        // agent collected for first time
        }else{
            
            $Agent = 'App\User'::findOrFail($order->agent_id);
            $specialSharedStatus    =   'App\SpecialTariff'::where([
                ['user_id','=',$order->agent_id],
                ['product_id','=',$order_product->product_id]
            ])->exists();

            if($specialSharedStatus == True){

                    $specialShared    =   'App\SpecialTariff'::where([
                        ['user_id','=',$order->agent_id],
                        ['product_id','=',$order_product->product_id]
                    ])->firstOrFail();
    
                    $balance    =   $specialShared->price;
                    if($AgentStatus == False){
                        $userInventory = 'App\UserInventory'::create([
                            'agent_id'  =>      $Agent->id,
                            'balance'   =>      $balance,
                            'debtor'    =>      1
                        ]);
                    }else{
                        $AgentInventory='App\UserInventory'::where('agent_id',$order->agent_id)->firstOrFail();
                        $AgentInventory->update(['balance'=>$balance,'debtor'=>1]);
                    }
         
                'App\MoneyCirculation'::create([
                    'user_inventory_id'     =>  $userInventory->id,
                    'agent_id'              =>  $Agent->id,
                    'order_product_id'      =>  $order_product->id,
                    'seller_id'             =>  null,
                    'order_status_id'       =>  $order->status,
                    'order_id'              =>  $order->id,
                    'amount'                =>  $order_product->product->price,
                    'sharedSpecialAmount'   =>  $balance,
                    'trackingCode'          =>  $trackingCode,
                ]);

                
            }else{
                $Agent = 'App\User'::findOrFail($order->agent_id);
                $placeNumber = $order->status;

                switch ($placeNumber){
                    case 10:
                        $balance = $Agent->internalPrice;
                        break;
                    case 11:
                        $balance = $Agent->locallyPrice;
                        break;
                    case 12:
                        $balance = $Agent->villagePrice;
                        break;
                }

                
                $userInventory = 'App\UserInventory'::create([
                    'agent_id'  =>      $Agent->id,
                    'balance'   =>      $balance,
                    'debtor'    =>  1
                ]);
                'App\MoneyCirculation'::create([
                    'user_inventory_id'     =>  $userInventory->id,
                    'agent_id'              =>  $Agent->id,
                    'order_product_id'      =>  $order_product->id,
                    'seller_id'             =>  null,
                    'order_status_id'       =>  $order->status,
                    'order_id'              =>  $order->id,
                    'amount'                =>  $order_product->product->price,
                    'sharedSpecialAmount'   =>  $balance,
                    'trackingCode'          =>  $trackingCode,
                ]);
            }

            // return response()->json(['message' => 'موفقیت آمیز بود','status' => 1]);

        }


    }
    /*
    |--------------------------------------------------------------------------
    | Factor
    |--------------------------------------------------------------------------
    |*/
    public function Factor($id){
        $order = 'App\Order'::findOrFail($id);
        $settings       = DB::table('settings');
        $Factor         = $settings->skip(0)->take(1)->get();
        $FactorStatus   = $settings->skip(0)->take(1)->exists();  
        if($FactorStatus){
            $Factor = $Factor[0];
        }  
        
        return view('Admin.Order.Factor',compact('order','Factor'));
    }
    /*
    |--------------------------------------------------------------------------
    | Seller No Action Orders
    |--------------------------------------------------------------------------
    |*/
    public function sellerNoActionOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['seller_id','=',$user->id],
            ['status','=',7],
        ])->latest()->paginate(15);
        
        return view('Admin.Order.Seller.seller-noAction-orders',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Unverified Order List
    |--------------------------------------------------------------------------
    |*/
    public function UnverifiedOrderList(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        
        /*## Agent ## */
        // $agents = array();
        // foreach($user->statesUnderControl as $state){
            
        //     foreach($state->cities as $city){
        //         $agents[] = 'App\User'::with('city')
        //         ->where('city_id',$city->id)
        //         ->Role('agent')->get();
        //     }

        // }
        // if(isset($agents[0])){
        //     $agents = $agents[0]->toArray();
        // }else{
        //     $agents = null; 
        // }
        $agents = 'App\User'::where([
            ['status','=','on']
        ])->Role('agent')->latest()->get();
        /*## Agent ## */
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
    /*
    |--------------------------------------------------------------------------
    | Seller Order CallBack
    |--------------------------------------------------------------------------
    |*/
    public function sellerOrderCallBack(){
     
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['seller_id','=',$user->id],
            ['status','=',13],//Customer Cancelled
            ])->latest()->get();
        
        return view('Admin.Order.Seller.order-callback',compact(
            'orders'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Receive Order From Agent
    |--------------------------------------------------------------------------
    |*/
    public function receiveOrderFromAgent(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
       
        /*####### Agent ####### */
        // $agents = array();
        // foreach($user->statesUnderControl as $state){
            
        //     foreach($state->cities as $city){
        //         $agents[] = 'App\User'::with('city')
        //         ->where('city_id',$city->id)
        //         ->Role('agent')->get();
        //     }

        // }
        // if(isset($agents[0])){
        //     $agents = $agents[0]->toArray();
        // }else{
        //     $agents = null; 
        // }
        $agents = 'App\User'::where([
            ['status','=','on']
        ])->Role('agent')->latest()->get();
        /*####### Agent ####### */

        $orders = Order::where([
            ['followUpManager_id','=',$user->id],
            ['status','=',8],//Receive Order From Agent
            ])->latest()->get();
        
        return view('Admin.Order.FollowUpManager.receive-order-fromAgent',compact(
            'orders',
            'agents'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | Choose Agent For Delivary
    |--------------------------------------------------------------------------
    |*/
    public function chooseAgentForDelivary(Request $request){
     
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $items = $request->orderNumbers;
        foreach($items as $item){
            $order = 'App\Order'::findOrFail($item['id']);
            $order->update([
                'status'        =>      7,
                'agent_id'      =>      $item['agent_id'],
                'delivary_Date' =>      Carbon::now()

                ]);
        }
        return response()->json(['message' => 'موفقیت آمیز بود','status' => 1]);
    }
    /*
    |--------------------------------------------------------------------------
    | Receive Order From FollowUpManager
    |--------------------------------------------------------------------------
    |*/
    public function receiveOrderFromFollowUpManager(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = Order::where([
            ['seller_id','=',$user->id],
            ['status','=',6],//Receive Order From FollowUpManager
            ])->latest()->get();

            return view('Admin.Order.Seller.receive-order-fromFollowUpManager',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Delivary Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentsDelivaryOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $agents = 'App\User'::where('agent_id',$user->id)->Role('agent')->latest()->get();
        
        $bottom_statuses = 'App\OrderStatus'::skip(9)->take(5)->get();
        $orders = 'App\Order'::where('agent_id',$user->id);

        foreach($agents as $agent){
            $orders->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',7]
            ]);
        }
        $orders = $orders->latest()->get();
    
        return view('Admin.Order.AgentChief.agents-orders',compact(
            'orders',
            'bottom_statuses'
        
        ));

    
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Collected Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentsCollectedOrders(){

        $user = 'App\User'::findOrFail(auth()->user()->id);
        $agents = 'App\User'::where('agent_id',$user->id)->Role('agent')->latest()->get();
        

        $orders = 'App\Order'::where('agent_id',$user->id);

        foreach($agents as $agent){
            $orders->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',10]
            ])
            ->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',11]
            ])->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',12]
            ]);
        }
        $orders = $orders->latest()->paginate(15);
    
        return view('Admin.Order.AgentChief.agents-collected-orders',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Cancelled Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentsCancelledOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $agents = 'App\User'::where('agent_id',$user->id)->Role('agent')->latest()->get();
        

        $orders = 'App\Order'::where('agent_id',$user->id);

        foreach($agents as $agent){
            $orders->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',13]
            ])
            ->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',16]
            ]);
        }
        $orders = $orders->latest()->paginate(15);
    
        return view('Admin.Order.AgentChief.agents-cancelled-orders',compact('orders'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Suspended Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentsSuspendedOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $agents = 'App\User'::where('agent_id',$user->id)->Role('agent')->latest()->get();
        

        $orders = 'App\Order'::where('agent_id',$user->id);

        foreach($agents as $agent){
            $orders->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',13]
            ])
            ->Orwhere([
                ['agent_id','=',$agent->id],
                ['status','=',16]
            ]);
        }
        $orders = $orders->latest()->paginate(15);
    
        return view('Admin.Order.AgentChief.agents-suspended-orders',compact('orders'));
    }
    
}
