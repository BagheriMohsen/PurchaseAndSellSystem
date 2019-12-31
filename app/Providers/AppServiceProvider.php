<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*
        |--------------------------------------------------------------------------
        | Set Role variable for admin sidebar
        |--------------------------------------------------------------------------
        |*/
        view()->composer('Admin.Master.sidebar',function($view){
            if(auth()->check()){
                // find user detail
                $user       = 'App\User'::find(auth()->user()->id);
                // find role name
                $roleName   = $user->getRoleNames()->first();
                // find role all detail
                $role = Role::where('name',$roleName)->firstOrFail();
                $view ->with(compact('role','user'));
            }
        });
        /*
        |--------------------------------------------------------------------------
        | Notification For Roles
        |--------------------------------------------------------------------------
        |*/
        view()->composer('Admin.Master.header',function($view){
            if(auth()->check()){
                // find user detail
                $user       = 'App\User'::find(auth()->user()->id);
                // find role name
                $roleName   = $user->getRoleNames()->first();
                // find role all detail
                $role = Role::where('name',$roleName)->firstOrFail();
                $notifs = 0;
                $AgentReturnedProduct = 0;
                $orderNotif = 0;
                $Agentpayments = 0;
                $Agentcosts =   0;
                if($roleName == "agent" || $roleName == "agentChief"){
                    $notifs = 'App\StoreRoom'::where(['receiver_id'=>$user->id,'in_out'=>10])
                    ->count();
              
                    $orderNotif = 'App\Order'::where(['agent_id'=>$user->id,'status'=>7])
                    ->count();
                }elseif($roleName == "fundWarehouser"){
                    $notifs = 'App\StoreRoom'::where(['warehouse_id'=>2,'in_out'=>5])
                    ->count();
                    $AgentReturnedProduct =  'App\StoreRoom'::where([
                        ['receiver_id','=',2],
                        ['in_out','=',16]
                    ])->count();
              
                }elseif($roleName == "mainWarehouser"){
                    $notifs = 'App\StoreRoom'::where(['in_out'=>15])->get()->count();
                   
                }elseif($roleName == "followUpManager"){
                   
                    $orderNotif = 'App\Order'::where(['followUpManager_id'=>$user->id,'status'=>3,'agent_id'=>null])
                    ->count();
                }elseif($roleName == "admin"){
                    $Agentpayments = 'App\PaymentCirculation'::where([
                        ['confirmDate','=',null],
                        ['type','=','payment']
                    ])
                    ->latest()->count();

                    $Agentcosts   =   'App\PaymentCirculation'::where([
                        ['confirmDate','=',null],
                        ['type','=','cost']
                    ])
                    ->latest()->count();
                  
                }else{
                    //
                }

                $view ->with(compact(
                    'role',
                    'notifs',
                    'orderNotif',
                    'AgentReturnedProduct',
                    'Agentpayments',
                    'Agentcosts'
                
                ));
            }
        });
        /*
        |--------------------------------------------------------------------------
        | Seller work information for sellers and admin
        |--------------------------------------------------------------------------
        |*/
        view()->composer('Admin.Master.Repetitive.sellers-info-modal',function($view){
            if(auth()->check()){
                // find user detail
                $sellers       = 'App\User'::Role('seller')->get();
                $sellerRegisters = array();
                $today = 'Carbon\Carbon'::now();
                $yesterday = 'Carbon\Carbon'::now()->subDays(1);
                $thirteenDaysAgo = 'Carbon\Carbon'::now()->subDays(30);
                foreach($sellers as $seller){
                    $name = $seller->name.' '.$seller->family;
                    $register = 'App\Order'::where([
                        ['seller_id','=',$seller->id],
                        ['created_at','<',$today],
                        ['created_at','>',$yesterday]
                    ])->get();

                    $collected = 'App\Order'::where([
                        ['seller_id','=',$seller->id],
                        ['status','=',10],
                        ['collected_Date','<',$today],
                        ['collected_Date','>',$thirteenDaysAgo]
                    ])
                    ->orWhere([
                        ['seller_id','=',$seller->id],
                        ['status','=',11],
                        ['collected_Date','<',$today],
                        ['collected_Date','>',$thirteenDaysAgo]
                    ])
                    ->orWhere([
                        ['seller_id','=',$seller->id],
                        ['status','=',12],
                        ['collected_Date','<',$today],
                        ['collected_Date','>',$thirteenDaysAgo]
                    ])
                    ->get();

                    $sellerRegisters[] = [
                        'Name'          =>  $name,
                        'Registercount' =>  $register->count(),
                        'Collected'     =>  $collected->count()
                    ];
                }
                $view ->with(compact('sellerRegisters'));
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Set Role variable for admin sidebar
        |--------------------------------------------------------------------------
        |*/
        view()->composer('Admin.Master.Repetitive.StoreRoom.edit-modal',function($view){
            if(auth()->check()){
                // find user detail
                $user       = 'App\User'::find(auth()->user()->id);
                // find role name
                $roleName   = $user->getRoleNames()->first();
                // find role all detail
                $role = Role::where('name',$roleName)->firstOrFail();
                // find Storage
                $products = 'App\Product'::latest()->get();
                
                $view ->with(compact('products'));
            }
        });


    }
}
