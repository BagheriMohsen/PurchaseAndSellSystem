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
                    $notifs = 'App\StoreRoom'::where(['rcv_agent_id'=>$user->id,'in_out'=>'sendToAgent'])
                    ->count();
                }elseif($roleName == "fundWarehouser"){
                    $notifs = 'App\StoreRoom'::where(['warehouse_id'=>2,'in_out'=>'sendToFund'])
                    ->count();
                }else{
                    $notifs = 0;
                }

                $view ->with(compact('role','notifs'));
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
