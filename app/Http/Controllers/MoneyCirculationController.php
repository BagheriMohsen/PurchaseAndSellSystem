<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;

use App\Order;
use App\PaymentCirculation;
use App\User;
use App\MoneyCirculation;
use App\BankAccount;

class MoneyCirculationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Agent Current Bills
    |--------------------------------------------------------------------------
    |*/
    public function AgentCurrentBills(){
        $user = User::findOrFail(auth()->user()->id);
        $AllSell = 
        MoneyCirculation::where('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)
        ->orWhere('agent_id',$user->id)->sum('amount');
            
        $AllSpecialShared = 'App\UserInventory'::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');
            
        $TotalSettle = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDays(1);
        $ThirtyDaysAgo = Carbon::now()->subDays(30);

        $totalDebtor = Order::where([
            ['agent_id','=',$user->id],
            ['collected_Date','!=',null]
        ])->sum('cashPrice');
        $totalCreditor = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['confirmDate','!=',null]
        ])
        ->sum('bill');
        
        $AllSell =   Order::where([
            ['collected_Date','!=',Null],
            ['agent_id','=',$user->id]
        ])->sum('cashPrice');

        $orders = Order::with("products")->where([
            ["collected_Date","!=", Null],
            ["agent_id","=", $user->id]
        ])->get();
        
        $Discount = 0;
        foreach( $orders as $order ) {
            $Discount += $order->products->sum("off");
        }

   
        $costs = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',5]
        ])->sum('bill');

        $payments = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])->sum('bill');

        $AllSpecialShared = 'App\UserInventory'::where([
            ['agent_id','=',$user->id]
        ])->sum('balance');


        $Allpayments = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',2]
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',5]
        ])
        ->get();

        $AllOrders = Order::where([
            ['collected_Date','!=',Null],
            ['agent_id','=',$user->id]
        ])->get();
        $Allpayments = $Allpayments->toArray();
        $AllOrders = $AllOrders->toArray();
        $transaction = array_merge($AllOrders,$Allpayments);

       

        return view('Admin.UserInventory.Agent.current-bills',compact(
            'AllSell',
            'AllSpecialShared',
            'payments',
            'costs',
            'TotalSettle',
            'user',
            'totalDebtor',
            'totalCreditor',
            'transaction',
            'Discount'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | current Bills Debtor
    |--------------------------------------------------------------------------
    |*/
    public function currentBillsDebtor($user_id){
        
        $totalDebtor = Order::with(array('MoneyCirculations'=>function($query)use($user_id){
            $query->select('id','order_id','sharedSpecialAmount')
            ->where('agent_id',$user_id)
            ->sum('sharedSpecialAmount');
        }))->where([
            ['agent_id','=',$user_id],
            ['collected_Date','!=',null]
        ])->latest()->get(['id','collected_Date','cashPrice']);

        return Response()->json([$totalDebtor],200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | current Bills Creditor
    |--------------------------------------------------------------------------
    |*/
    public function currentBillsCreditor($user_id){
        
        $totalCreditor = PaymentCirculation::where([
            ['user_id','=',$user_id],
            ['confirmDate','!=',null]
        ])
        ->latest()->get(['id','status_id','billDate','bill']);

        return Response()->json([$totalCreditor],200,[],JSON_UNESCAPED_UNICODE);
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payment Orders
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentOrders(){
        
        $user = User::findOrFail(auth()->user()->id);
        $carts = BankAccount::where('user_id',$user->id)->latest()->get();
        $orders = Order::where([
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
        $user = User::findOrFail(auth()->user()->id);
        $payments = PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',1]
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',2],
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',3],
        ])
        ->latest()->paginate(15);
        
        return view('Admin.UserInventory.Agent.payment-list',compact('payments'));

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payment Delete
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentDelete($id){
        $payment = PaymentCirculation::findOrFail($id);

        if(!is_null($payment->confirmDate)){
            return back()->with('info','متاسفانه شما دیر اقدام کردید');
        }

        PaymentCirculation::destroy($id);
        return back()->with('message','پرداخت مورد نظر از لیست پرداخت های شما پاک گردید');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Payment List Update
    |--------------------------------------------------------------------------
    |*/
    public function AgentPaymentListUpdate(Request $request,$id){
        $payment = PaymentCirculation::findOrFail($id);

        if(!is_null($payment->confirmDate)){
            return back()->with('info','متاسفانه شما دیر اقدام کردید');
        }

        if($request->hasFile('image')){
            Storage::disk('public')->delete($payment->receiptImage);
            $image = Storage::disk('public')->put('AgentPaymentImage',$request->image);
        }else{
            $image = $payment->image; 
        }
        $payment->update([
            'receiptImage'  =>  $image,
            'bill'          =>  (float) str_replace(',', '', $request->bill),
            'billDesc'      =>  $request->desc
        ]);
        return back()->with('message','اطلاعات پرداخت به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs List
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostsList(){
        $user       =   User::findOrFail(auth()->user()->id);
        $costs   =   PaymentCirculation::where([
            ['user_id','=',$user->id],
            ['status_id','=',4],
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',5],
        ])
        ->orWhere([
            ['user_id','=',$user->id],
            ['status_id','=',6],
        ])
        ->latest()->paginate(15);
        
        return view('Admin.UserInventory.Agent.costs-list',compact('costs'));

    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs Store
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostsStore(Request $request){
      
        $user = User::findOrFail(auth()->user()->id);
        $date = Carbon::parse($request->date)->toDateString();
        PaymentCirculation::create([
            'billDate'      =>  $date,
            'status_id'     =>  4,
            'trackingCode'  =>  uniqid(),
            'user_id'       =>  $user->id,
            'bill'          =>  (float) str_replace(',', '', $request->price),
            'billDesc'      =>  $request->desc,
        ]);

        return back()->with('message','هزینه با موفقیت ثبت شد');
    }
     /*
    |--------------------------------------------------------------------------
    | Agent Costs Delete
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostsDelete($id){
        
        PaymentCirculation::where('id',$id)->delete();

        return back()->with('message','با موفقیت پاک شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs Update
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostsUpdate(Request $request,$id){
       
        PaymentCirculation::where('id',$id)->update([
            'billDate'      =>  $request->date,
            'bill'          =>  (float) str_replace(',', '', $request->price),
            'billDesc'      =>  $request->desc,
        ]);

        return back()->with('message','با موفقیت به روز رسانی شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs Update
    |--------------------------------------------------------------------------
    |*/
    public function AgentCostConfirm($id){

        $cost = PaymentCirculation::findOrFail($id);
        $cost->update([
            'status_id'      =>  5,
            'confirmDate'    =>  Carbon::now()
        ]);

        return back()->with('message','هزینه تایید شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Costs Update
    |--------------------------------------------------------------------------
    |*/
    public function AgentUnverifiedCosts(){
        
        
        $costs   =   PaymentCirculation::where([
            ['confirmDate','=',null],
            ['status_id','=',4]
        ])
        ->latest()->paginate(15);

        return view('Admin.UserInventory.Admin.unverfied-agent-costs',compact('costs'));
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
        $payments = PaymentCirculation::where([
            ['status_id','=',1],
            ['OnconfirmDate','=',null]
        ])
        ->latest()->paginate(15);
        return view('Admin.UserInventory.Admin.unverified-payment',compact('payments'));
    }
    /*
    |--------------------------------------------------------------------------
    | Cart Store
    |--------------------------------------------------------------------------
    |*/
    public function cartStore(Request $request){
        
        BankAccount::create([
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
        $user = User::findOrFail(auth()->user()->id);
        BankAccount::where('user_id',$user->id)->update(['default'=>0]);

        $cart = BankAccount::findOrFail($id);
        $cart->update(['default'=>1]);

        return back()->with('message',' کارت مورد نظر به عنوان کارت پیش فرض انتخاب شد');

    }
    /*
    |--------------------------------------------------------------------------
    | Cart Delete
    |--------------------------------------------------------------------------
    |*/
    public function cartDelete($id){

        $cart = BankAccount::destroy($id);
        return back()->with('message','کارت مورد نظر از لیست حذف شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agent Pay Money
    |--------------------------------------------------------------------------
    |*/
    public function AgentPayMoney(Request $request){

        $user = User::findOrFail(auth()->user()->id);
       
        if($request->hasFile('image')){
            $image = Storage::disk('public')->put('AgentPaymentImage',$request->image);
        }else{
            $image = null;
        }
  
        $date = Carbon::parse($request->date);
        
        PaymentCirculation::create([
                'receiptImage'  =>  $image,
                'user_id'       =>  $user->id,
                'status_id'     =>  1,
                'bill'          =>  (float) str_replace(',', '', $request->bill),
                'billDate'      =>  $date,
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
        $pay = PaymentCirculation::findOrFail($id);
        $pay->update([
            'status_id'     =>  2,
            'confirmDate'   =>  Carbon::now()
            ]);

        return back()->with('message','فیش واریزی تایید و در حساب جاری نماینده اعمال شد');
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Money Circulation
    |--------------------------------------------------------------------------
    |*/
    public function AgentsMoneyCirculation(){

        $user = User::findOrFail(auth()->user()->id);

        $agents = User::where('agent_id',$user->id)->Role('agent')->latest()->paginate(15);
        
        return view('Admin.UserInventory.AgentChief.agents-money-circulation',compact('agents'));
    }
    /*
    |--------------------------------------------------------------------------
    | Agents Payment List
    |--------------------------------------------------------------------------
    |*/
    public function AgentsPaymentList($agent_id){

        $user = User::findOrFail(auth()->user()->id);

        $agent = User::findOrFail($agent_id);

        if($agent->agent_id != $user->id){
            return abort(404);
        }

        $payments = PaymentCirculation::where([
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
    /*
    |--------------------------------------------------------------------------
    | Reject Payment
    |--------------------------------------------------------------------------
    |*/
    public function RejectPayment($id){
        $payment = PaymentCirculation::findOrFaIL($id);

        $payment->update([
            'status_id'     =>  3,
            'OnconfirmDate' =>  Carbon::now()
        ]);

        return back()->with('message','پرداخت مورد نظر پذیرفته نشد');

    }
    /*
    |--------------------------------------------------------------------------
    | Reject Cost
    |--------------------------------------------------------------------------
    |*/
    public function RejectCost($id){

        $payment = PaymentCirculation::findOrFaIL($id);

        $payment->update([
            'status_id'     =>  6,
            'OnconfirmDate' =>  Carbon::now()
        ]);

        return back()->with('message','هزینه مورد نظر پذیرفته نشد');

    }

   
}
