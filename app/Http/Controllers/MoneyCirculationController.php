<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoneyCirculationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Agent Current Bills
    |--------------------------------------------------------------------------
    |*/
    public function AgentCurrentBills(){
        
        return view('Admin.UserInventory.Agent.current-bills');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payment Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentOrders(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $orders = 'App\Order'::where([
            ['agent_id','=',$user->id],
            ['status','=',10]
        ])
        ->orWhere([
            ['agent_id','=',$user->id],
            ['status','=',11]
        ])
        ->orWhere([
            ['agent_id','=',$user->id],
            ['status','=',12]
        ])->latest()->paginate(10);
        return view('Admin.UserInventory.Agent.payment-orders',compact('orders'));

    }
    /*
    |--------------------------------------------------------------------------
    | Agent PrePayment List
    |--------------------------------------------------------------------------
    |*/
    public function AgentPrePaymentList(){
        return view('Admin.UserInventory.Agent.prepayment-list');

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payment List
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentList(){
        return view('Admin.UserInventory.Agent.payment-list');

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs List
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostsList(){
        return view('Admin.UserInventory.Agent.costs-list');

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payback List
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaybackList(){
        return view('Admin.UserInventory.Agent.payback-list');

    }
    /*
    |--------------------------------------------------------------------------
    | Agent payment Settlement
    |--------------------------------------------------------------------------
    |*/
    public function AgentpaymentSettlement(){
        return view('Admin.UserInventory.Agent.payment-settlement');

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Unverified Payment
    |--------------------------------------------------------------------------
    |*/
    public function AgentUnverifiedPayment(){
        return view('Admin.UserInventory.Admin.unverified-payment');
    }

}
