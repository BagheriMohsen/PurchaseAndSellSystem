<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Advanced Search Page
    |--------------------------------------------------------------------------
    |*/
    public function AdminAdvancedSearchPage(){
        $agents             =   'App\User'::Role('agent')->get();
        $callCenters        =   'App\User'::Role('callcenter')->get();
        $sellers            =   'App\User'::Role('seller')->get();   
        $followUpManagers   =   'App\User'::Role('followUpManager')->get();
        $statuses           =   'App\OrderStatus'::where([
            ['id','!=',1],
            ['id','!=',3],
            ['id','!=',4],
        ])->get();
        $states     =   'App\State'::latest()->get();
        $cities     =   'App\City'::latest()->get();
        $products   =   'App\Product'::latest()->get();
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
       
        $orders = 'App\Order'::query()
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
        ->latest()->paginate(10);
        
        return view('Admin.Search.Admin.search-result',compact('orders'));

    }


        

    


}
