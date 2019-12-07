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
        $carts = 'App\BankAccount'::where('user_id',$user->id)->latest()->get();
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
        return view('Admin.UserInventory.Agent.payment-orders',compact('orders','carts'));

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
    /*
    |--------------------------------------------------------------------------
    | Cart Store
    |--------------------------------------------------------------------------
    |*/
    public function cartStore(Request $request){
        
        'App\BankAccount'::create([
            'name'          =>  $request->name,
            'user_id'       =>  auth()->user()->id,
            'cartNumber'    =>  $request->cartNumber,
            'shabaNumber'   =>  $request->shabaNumber,
        ]);

        return redirect()->back()->with('message','شماره کارت شما با موفقیت ثبت شد');

    }
    /*
    |--------------------------------------------------------------------------
    | Cart set default
    |--------------------------------------------------------------------------
    |*/
    public function cartSetDefault(Request $request,$id){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        'App\BankAccount'::where('user_id',$user->id)->update(['default'=>0]);

        $cart = 'App\BankAccount'::findOrFail($id);
        $cart->update(['default'=>1]);

        return back()->with('message',' کارت مورد نظر به عنوان کارت پیش فرض انتخاب شد');

    }
    /*
    |--------------------------------------------------------------------------
    | Cart Delete
    |--------------------------------------------------------------------------
    |*/
    public function cartDelete($id){

        $cart = 'App\BankAccount'::destroy($id);
        return back()->with('message','کارت مورد نظر از لیست حذف شد');
    }

}
