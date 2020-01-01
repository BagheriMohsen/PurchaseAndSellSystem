<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Costs report page
    |--------------------------------------------------------------------------
    |*/
    public function Costs(){
        $agents = 'App\User'::Role('agent')->latest()->get();
        return view('Admin.Report.Admin.costs',compact('agents'));
    }
    /*
    |--------------------------------------------------------------------------
    | Orders report page
    |--------------------------------------------------------------------------
    |*/
    public function Orders(){
        return view('Admin.Report.Admin.orders');
    }
    /*
    |--------------------------------------------------------------------------
    | Payment report page
    |--------------------------------------------------------------------------
    |*/
    public function Payments(){
        $agents = 'App\User'::Role('agent')->latest()->get();
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
        $costs = 'App\PaymentCirculation'::query()
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
       
        $payments = 'App\PaymentCirculation'::query()
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
}
