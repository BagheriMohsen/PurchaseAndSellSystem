<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\PaymentCirculation;
use App\Models\Order;


class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Costs report page
    |--------------------------------------------------------------------------
    |*/
    public function Costs(){
        $agents = User::Role('agent')->latest()->get();
        return view('Admin.Report.Admin.costs',compact('agents'));
    }
    /*
    |--------------------------------------------------------------------------
    | Orders report page
    |--------------------------------------------------------------------------
    |*/
    public function Orders(){
        $statuses   =   OrderStatus::where([
            ['id','!=',1],
            ['id','!=',15],
            ['id','!=',9],
        ])->get();
        $agents             =   User::with(["state","city"])->Role('agent')->get();
        $callCenters        =   User::Role('callcenter')->get();
        $sellers            =   User::Role('seller')->get();   
        $followUpManagers   =   User::Role('followUpManager')->get();
        $products           =   Product::latest()->get();
        return view('Admin.Report.Admin.orders',compact(
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
    | Payment report page
    |--------------------------------------------------------------------------
    |*/
    public function Payments(){
        $agents = User::Role('agent')->latest()->get();
        return view('Admin.Report.Admin.payments',compact('agents'));
    }
    /*
    |--------------------------------------------------------------------------
    | Cost Data Filter
    |--------------------------------------------------------------------------
    |*/
    public function costs_filter(Request $request){

        $from       =   $request->from;
        $to         =   $request->to;
        $agent      =   $request->agents;
        $status_id  =   5;
        $costs = PaymentCirculation::query()
        ->when($from,function($query,$from){
            return $query->where('updated_at','>=',$from);
        })
        ->when($to,function($query,$to){
            return $query->where('updated_at', '<=',$to);
        })
        ->when($status_id,function($query,$status_id){
            return $query->where('status_id', '=',$status_id);
        })
        ->when($agent,function($query,$agent){
            return $query->where('user_id', '=',$agent);
        })->latest()->paginate(15);
        
        return view('Admin.Report.Admin.costs-result',compact('costs'));
    }
    /*
    |--------------------------------------------------------------------------
    | Payment Data Filter
    |--------------------------------------------------------------------------
    |*/
    public function payments_filter(Request $request){

        $from       =   $request->from;
        $to         =   $request->to;
        $agent      =   $request->agents;
        $status_id  =   $request->report_status;
       
        $payments = PaymentCirculation::query()
        ->when($from,function($query,$from){
            return $query->where('updated_at','>=',$from);
        })
        ->when($to,function($query,$to){
            return $query->where('updated_at', '<=',$to);
        })
        ->when($status_id,function($query,$status_id){
            return $query->where('status_id', '=',$status_id);
        })
        ->when($agent,function($query,$agent){
            return $query->where('user_id', '=',$agent);
        })->latest()->get();
       
        return view('Admin.Report.Admin.payments-result',compact('payments'));
    }

    /*
    |--------------------------------------------------------------------------
    | Order Data Filter
    |--------------------------------------------------------------------------
    |*/
    public function orders_filter(Request $request){

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
        $agent              =   $request->agent;
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

    /*
    |--------------------------------------------------------------------------
    | Agents All Report
    |--------------------------------------------------------------------------
    |*/
    public function AgentsAllReport() {
        $user = auth()->user();

        $agents = User::where("agent_id", $user->id)->get();

     

        return view("Admin.Report.AgentChief.report-result");
    }


}
