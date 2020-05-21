<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\OrderStatus;
use App\Models\State;
use App\Models\City;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;


class SearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Advanced Search Page
    |--------------------------------------------------------------------------
    |*/
    public function AdminAdvancedSearchPage(){
        $agents             =   User::Role('agent')->get();
        $callCenters        =   User::Role('callCenter')->get();
        $sellers            =   User::Role('seller')->get();   
        $followUpManagers   =   User::Role('followUpManager')->get();
        $statuses           =   OrderStatus::where([
            ['id','!=',1],
            ['id','!=',3],
            ['id','!=',4],
        ])->get();
        $states     =   State::latest()->get();
        $cities     =   City::latest()->get();
        $products   =   Product::latest()->get();
        return view('Admin.Search.Admin.index',compact(
            'agents',
            'callCenters',
            'sellers',
            'followUpManagers',
            'statuses',
            'states',
            'cities',
            'products'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Advanced Search Show Results
    |--------------------------------------------------------------------------
    |*/
    public function AdminAdvancedSearch(Request $request){
       
     
        $from_register      =   $request->from_register;
        $to_register        =   $request->to_register_date;
        $from_collected     =   $request->from_register_date;
        $to_collected       =   $request->to_deliver_date;
        $callCenter         =   $request->callcenter;
        $followUpManager    =   $request->follow_manager;
        $agent              =   $request->agent;
        $status             =   $request->status;
        $seller             =   $request->seller;
        $name               =   $request->name;
        $telephone          =   $request->telephone;
        $mobile             =   $request->mobile;
        $address            =   $request->address;
        $postalCode         =   $request->postal_code;
        $product            =   $request->product;
        $state              =   $request->state;
        $city               =   $request->city;
       
        $orders = Order::query()
        ->when($from_register,function($query,$from_register){
            return $query->where('created_at','>=',$from_register);
        })->when($to_register,function($query,$to_register){
            return $query->where('created_at', '<=',$to_register);
        })
        ->when($from_collected,function($query,$from_collected){
            return $query->where('updated_at', '>=',$from_collected);
        })
        ->when($to_collected,function($query,$to_collected){
            return $query->where('updated_at', '<=',$to_collected);
        })
        ->when($followUpManager,function($query,$followUpManager){
            return $query->where('followUpManager_id','=',$followUpManager);
        })
        ->when($agent,function($query,$agent){
            return $query->where('agent_id','=',$agent) ;         
        })
        ->when($status,function($query,$status){
            return $query->where('status','=',$status);
        })
        ->when($callCenter,function($query,$callCenter){
            return $query->where('callCenter_id','=',$callCenter);
        })
        ->when($seller,function($query,$seller){
            return $query->where('seller_id','=',$seller);
        })
        ->when($telephone,function($query,$telephone){
            return $query->where('telephone','LIKE',"%{$telephone}%"); 
        })
        ->when($mobile,function($query,$mobile){
            return $query->where('mobile', 'LIKE',"%{$mobile}%") ;
        })
        ->when($address,function($query,$address){
            return $query->where('address','LIKE',"%{$address}%");
        })
        ->when($postalCode,function($query,$postalCode){
            return $query->where('postalCode','LIKE',"%{$postalCode}%"); 
        })
        ->when($product,function($query,$product){
            return $query->where('product', '=',$product); 
        })
        ->when($state,function($query,$state){
            return $query->where('state_id', '=',$state); 
        })
        ->when($city,function($query,$city){
            return $query->where('city_id','=',$city); 
        })
        ->with([
            "products",
            "seller",
            "callCenter",
            "followUpManager",
            "OrderStatus",
            "agent"
        ])
        ->latest()
        ->paginate(10);
        
        return view('Admin.Search.Admin.search-result',compact('orders'));

    }

    /*
    |--------------------------------------------------------------------------
    | Agent Chief Advanced Search Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentChiefAdvancedSearchPage() {
        $user               =   auth()->user();
        $agents             =   User::where("agent_id", $user->id)->get();
        $callCenters        =   User::Role('callCenter')->get();
        $sellers            =   User::Role('seller')->get();   
        $followUpManagers   =   User::Role('followUpManager')->get();
        $statuses           =   OrderStatus::where([
            ['id','!=',1],
            ['id','!=',3],
            ['id','!=',4],
        ])->get();
        $states     =   State::latest()->get();
        $cities     =   City::latest()->get();
        $products   =   Product::latest()->get();
        return view('Admin.Search.AgentChief.index',compact(
            'agents',
            'callCenters',
            'sellers',
            'followUpManagers',
            'statuses',
            'states',
            'cities',
            'products'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Agent Chief Advanced Search
    |--------------------------------------------------------------------------
    |*/
    public function AgentChiefAdvancedSearch(Request $request){
       
        $user = auth()->user();
        $agents = User::where("agent_id", $user->id)->get();
        $from_register      =   $request->from_register;
        $to_register        =   $request->to_register_date;
        $from_collected     =   $request->from_register_date;
        $to_collected       =   $request->to_deliver_date;
        $callCenter         =   $request->callcenter;
        $followUpManager    =   $request->follow_manager;
        $agent              =   $request->agent;
        $status             =   $request->status;
        $seller             =   $request->seller;
        $name               =   $request->name;
        $telephone          =   $request->telephone;
        $mobile             =   $request->mobile;
        $address            =   $request->address;
        $postalCode         =   $request->postal_code;
        $product            =   $request->product;
        $state              =   $request->state;
        $city               =   $request->city;
       
        $orders = Order::query()
        ->when($from_register,function($query,$from_register){
            return $query->where('created_at','>=',$from_register);
        })->when($to_register,function($query,$to_register){
            return $query->where('created_at', '<=',$to_register);
        })
        ->when($from_collected,function($query,$from_collected){
            return $query->where('updated_at', '>=',$from_collected);
        })
        ->when($to_collected,function($query,$to_collected){
            return $query->where('updated_at', '<=',$to_collected);
        })
        ->when($followUpManager,function($query,$followUpManager){
            return $query->where('followUpManager_id','=',$followUpManager);
        })
     
        ->when($status,function($query,$status){
            return $query->where('status','=',$status);
        })
        ->when($callCenter,function($query,$callCenter){
            return $query->where('callCenter_id','=',$callCenter);
        })
        ->when($seller,function($query,$seller){
            return $query->where('seller_id','=',$seller);
        })
        ->when($telephone,function($query,$telephone){
            return $query->where('telephone','LIKE',"%{$telephone}%"); 
        })
        ->when($mobile,function($query,$mobile){
            return $query->where('mobile', 'LIKE',"%{$mobile}%") ;
        })
        ->when($address,function($query,$address){
            return $query->where('address','LIKE',"%{$address}%");
        })
        ->when($postalCode,function($query,$postalCode){
            return $query->where('postalCode','LIKE',"%{$postalCode}%"); 
        })
        ->when($product,function($query,$product){
            return $query->where('product', '=',$product); 
        })
        ->when($state,function($query,$state){
            return $query->where('state_id', '=',$state); 
        })
        ->when($city,function($query,$city){
            return $query->where('city_id','=',$city); 
        })
        ->when($agent,function($query,$agent){
            return $query->where('agent_id','=',$agent) ;         
        })->with([
            "products",
            "seller",
            "callCenter",
            "followUpManager",
            "OrderStatus",
            "agent"
        ])
        ->latest()
        ->paginate(10);
        
        return view('Admin.Search.AgentChief.search-result',compact('orders'));

    }


        
    /*
    |--------------------------------------------------------------------------
    | Agent Advanced Search Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentAdvancedSearchPage() {
        $user               =   auth()->user();
        $callCenters        =   User::Role('callCenter')->get();
        $sellers            =   User::Role('seller')->get();   
        $followUpManagers   =   User::Role('followUpManager')->get();
        $statuses           =   OrderStatus::where([
            ['id','!=',1],
            ['id','!=',3],
            ['id','!=',4],
        ])->get();
        $states     =   State::latest()->get();
        $cities     =   City::latest()->get();
        $products   =   Product::latest()->get();
        return view('Admin.Search.Agent.index',compact(
            'callCenters',
            'sellers',
            'followUpManagers',
            'statuses',
            'states',
            'cities',
            'products'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Agent  Advanced Search
    |--------------------------------------------------------------------------
    |*/
    public function AgentAdvancedSearch(Request $request){
       
        $user = auth()->user();

        $from_register      =   $request->from_register;
        $to_register        =   $request->to_register_date;
        $from_collected     =   $request->from_register_date;
        $to_collected       =   $request->to_deliver_date;
        $callCenter         =   $request->callcenter;
        $followUpManager    =   $request->follow_manager;
        $agent              =   $user->id;
        $status             =   $request->status;
        $seller             =   $request->seller;
        $name               =   $request->name;
        $telephone          =   $request->telephone;
        $mobile             =   $request->mobile;
        $address            =   $request->address;
        $postalCode         =   $request->postal_code;
        $product            =   $request->product;
        $state              =   $request->state;
        $city               =   $request->city;
       
        $orders = Order::query()
        ->when($from_register,function($query,$from_register){
            return $query->where('created_at','>=',$from_register);
        })->when($to_register,function($query,$to_register){
            return $query->where('created_at', '<=',$to_register);
        })
        ->when($from_collected,function($query,$from_collected){
            return $query->where('updated_at', '>=',$from_collected);
        })
        ->when($to_collected,function($query,$to_collected){
            return $query->where('updated_at', '<=',$to_collected);
        })
        ->when($followUpManager,function($query,$followUpManager){
            return $query->where('followUpManager_id','=',$followUpManager);
        })
        ->when($agent,function($query,$agent){
            return $query->where('agent_id','=',$agent) ;         
        })
        ->when($status,function($query,$status){
            return $query->where('status','=',$status);
        })
        ->when($callCenter,function($query,$callCenter){
            return $query->where('callCenter_id','=',$callCenter);
        })
        ->when($seller,function($query,$seller){
            return $query->where('seller_id','=',$seller);
        })
        ->when($telephone,function($query,$telephone){
            return $query->where('telephone','LIKE',"%{$telephone}%"); 
        })
        ->when($mobile,function($query,$mobile){
            return $query->where('mobile', 'LIKE',"%{$mobile}%") ;
        })
        ->when($address,function($query,$address){
            return $query->where('address','LIKE',"%{$address}%");
        })
        ->when($postalCode,function($query,$postalCode){
            return $query->where('postalCode','LIKE',"%{$postalCode}%"); 
        })
        ->when($product,function($query,$product){
            return $query->where('product', '=',$product); 
        })
        ->when($state,function($query,$state){
            return $query->where('state_id', '=',$state); 
        })
        ->when($city,function($query,$city){
            return $query->where('city_id','=',$city); 
        })
        ->with([
            "products",
            "seller",
            "callCenter",
            "followUpManager",
            "OrderStatus",
            "agent"
        ])
        ->latest()
        ->paginate(10);
        
        return view('Admin.Search.Agent.search-result',compact('orders'));

    }

    /*
    |--------------------------------------------------------------------------
    | Agent Order Search Page
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderSearchPage() {
        $statuses   =   OrderStatus::where([
            ['id','!=',1],
            ['id','!=',15],
            ['id','!=',9],
        ])->get();
        $agents             =   User::with(["state","city"])->Role('agent')->get();
        $callCenters        =   User::Role('callCenter')->get();
        $sellers            =   User::Role('seller')->get();   
        $followUpManagers   =   User::Role('followUpManager')->get();
        $products           =   Product::latest()->get();
        return view('Admin.Search.Agent.orders-report',compact(
            'statuses',
            'agents',
            'sellers',
            'callCenters',
            'followUpManagers',
            'products'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Agent Order Search
    |--------------------------------------------------------------------------
    |*/
    public function AgentOrderSearch(Request $request){

        $user = auth()->user();

        $from  =   Carbon::parse($request->from);
        $to    =   Carbon::parse($request->to);

        if($from == $to) {
            $from->subDay(1);
            $to->addDay(1);
        }

        $date_status        =   $request->date_status;

        $from_updated_at    =   null;
        $to_updated_at      =   null;              
        $from_edit_Date     =   null;
        $to_edit_Date       =   null;              
        $from_delivary_Date =   null;
        $to_delivary_Date   =   null;                 
        $from_created_at    =   null;
        $to_created_at      =   null; 


        if($date_status == 'action_Date'){
            $from_updated_at = $from ;
            $to_updated_at  =  $to;              
        }elseif($date_status == 'edit_Date'){
            $from_edit_Date = $from ;
            $to_edit_Date   =  $to;              
        }elseif($date_status == 'allotment_Date'){
            $from_delivary_Date = $from ;
            $to_delivary_Date   =  $to;                 
        }else{
            $from_created_at    = $from ;
            $to_created_at      =  $to;              
        }


        $callCenter         =   $request->callcenter;
        $followUpManager    =   $request->follow_manager;
        $agent              =   $user->id;
        $status             =   $request->status;
        $seller             =   $request->seller;
        $product            =   $request->product;
       
       
       
      
        $orders = Order::query()
     
        ->when($from_created_at,function($query,$from_created_at){
            return $query->where('created_at','>=',$from_created_at);
        })->when($to_created_at,function($query,$to_created_at){
            return $query->where('created_at', '<=',$to_created_at);
        })

        ->when($from_updated_at,function($query,$from_updated_at){
            return $query->where('action_Date','>=',$from_updated_at);
        })->when($to_updated_at,function($query,$to_updated_at){
            return $query->where('action_Date', '<=',$to_updated_at);
        })


        ->when($from_edit_Date,function($query,$from_edit_Date){
            return $query->where('edit_Date','>=',$from_edit_Date);
        })->when($to_edit_Date,function($query,$to_edit_Date){
            return $query->where('edit_Date', '<=',$to_edit_Date);
        })


        ->when($from_delivary_Date,function($query,$from_delivary_Date){
            return $query->where('allotment_Date','>=',$from_delivary_Date);
        })->when($to_delivary_Date,function($query,$to_delivary_Date){
            return $query->where('allotment_Date', '<=',$to_delivary_Date);
        })


        ->when($followUpManager,function($query,$followUpManager){
            return $query->where('followUpManager_id','=',$followUpManager);
        })
        ->when($agent,function($query,$agent){
            return $query->where('agent_id','=',$agent) ;         
        })
        ->when($status,function($query,$status){
            return $query->where('status','=',$status);
        })
        ->when($callCenter,function($query,$callCenter){
            return $query->where('callCenter_id','=',$callCenter);
        })
        ->when($seller,function($query,$seller){
            return $query->where('seller_id','=',$seller);
        })
        ->with(["agent","seller","followUpManager","OrderStatus","products"])
        ->latest()->get();
       
        return view('Admin.Report.Admin.orders-result',compact(
            'orders',
            'status'
        
        ));
    }

    


}
