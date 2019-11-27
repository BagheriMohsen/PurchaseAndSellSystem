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

                if($roleName == "agent" || $roleName == "agentChief"){
                    $notifs = 'App\StoreRoom'::where(['receiver_id'=>$user->id,'in_out'=>10])
                    ->count();
                    $orderNotif = 'App\Order'::where(['agent_id'=>$user->id,'status'=>1])
                    ->count();
                }elseif($roleName == "fundWarehouser"){
                    $notifs = 'App\StoreRoom'::where(['warehouse_id'=>2,'in_out'=>5])
                    ->count();
                    $orderNotif = 0;
                }else{
                    $notifs = 0;
                    $orderNotif = 0;
                }

                $view ->with(compact('role','notifs','orderNotif'));
            }
        });
        /*
        |--------------------------------------------------------------------------
        | Seller work information for sellers and admin
        |--------------------------------------------------------------------------
        |*/
        view()->composer('Admin.Master.sellers-info',function($view){
            if(auth()->check()){
                // find user detail
                $sellers       = 'App\User'::Role('seller')->get();
                $view ->with(compact('sellers'));
            }
        });

    }
}
