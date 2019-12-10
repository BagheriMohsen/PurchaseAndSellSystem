<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class MoneyCirculationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Agent Current Bills
    |--------------------------------------------------------------------------
    |*/
    public function AgentCurrentBills(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $AllSell = 
        'App\MoneyCirculation'::where('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)->sum('amount');
            
        $AllSpecialShared = 'App\UserInventory'::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');
            
        $TotalSettle = 'App\PaymentCirculation'::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');
        return view('Admin.UserInventory.Agent.current-bills',compact(
            'AllSell',
            'AllSpecialShared',
            'TotalSettle',
            'user'
        ));
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
    | Agent Payment List
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentList(){
        $user = 'App\User'::findOrFail(auth()->user()->id);
        $payments = 'App\PaymentCirculation'::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',1],
        ])
        ->latest()->paginate(15);
        
        return view('Admin.UserInventory.Agent.payment-list',compact('payments'));

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
        $payments = 'App\PaymentCirculation'::where('status_id',1)
        ->latest()->paginate(15);
        return view('Admin.UserInventory.Admin.unverified-payment',compact('payments'));
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
    /*
    |--------------------------------------------------------------------------
    | Agent Pay Money
    |--------------------------------------------------------------------------
    |*/
    public function AgentPayMoney(Request $request){

        $user = 'App\User'::findOrFail(auth()->user()->id);
       
        if($request->hasFile('image')){
            $image = Storage::disk('public')->put('AgentPaymentImage',$request->image);
        }else{
            $image = null;
        }
        
        'App\PaymentCirculation'::create([
                'receiptImage'  =>  $image,
                'user_id'       =>  $user->id,
                'status_id'     =>  1,
                'bill'          =>  (float) str_replace(',', '', $request->bill),
                'billDate'      =>  $request->date,
                'trackingCode'  =>  (float) str_replace(',', '', $request->trackingCode),
                'paymentMethod' =>  $request->paymentMethod,
                'billDesc'      =>  $request->billDesc
            ]);
        return back()->with('message','اطلاعات به درستی ارسال شد.پس از تایید مدیریت در حساب جاری شما اعمال میشود');

    }
    /*
    |--------------------------------------------------------------------------
    | Admin Accept Agent Payment
    |--------------------------------------------------------------------------
    |*/
    public function AdminAcceptAgentPayment($id){
        $pay = 'App\PaymentCirculation'::findOrFail($id);
        $pay->update([
            'status_id'     =>  2,
            'confirmDate'   =>  Carbon::now()
            ]);

        return back()->with('message','فیش واریزی تایید و در حساب جاری نماینده اعمال شد');
    }

    public function AgentsMoneyCirculation(){

        $user = 'App\User'::findOrFail(auth()->user()->id);

        $agents = 'App\User'::where('agent_id',$user->id)->Role('agent')->latest()->paginate(15);
        
        return view('Admin.UserInventory.AgentChief.agents-money-circulation',compact('agents'));
    }

    public function AgentsPaymentList($agent_id){

        $user = 'App\User'::findOrFail(auth()->user()->id);

        $agent = 'App\User'::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(404);
        }

        $payments = 'App\PaymentCirculation'::where([
            ['user_id','=',$agent_id],
            ['status_id','=',2]
        ])
        ->orWhere([
            ['user_id','=',$agent_id],
            ['status_id','=',1],
        ])
        ->latest()->paginate(15);
        
        return view('Admin.UserInventory.AgentChief.agents-payment-list',compact('payments'));

    }

   
}
