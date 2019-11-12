<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $NormalUser         = Role::create(['name'=>'normalUser','persianName'=>'کاربر عادی']);
        $agent              = Role::create(['name'=>'agent','persianName'=>'نماینده']);
        $agentChief         = Role::create(['name'=>'agentChief','persianName'=>'مدیر نماینده']);
        $seller             = Role::create(['name'=>'seller','persianName'=>'فروشنده']);
        $admin              = Role::create(['name'=>'admin','persianName'=>'ادمین سایت']);
        $followUpManager    = Role::create(['name'=>'followUpManager','persianName'=>'مدیر پیگیری']);
        $mainwarehouser     = Role::create(['name'=>'mainWarehouser','persianName'=>'انبارگردان مادر']);
        $fundwarehouser     = Role::create(['name'=>'fundWarehouser','persianName'=>'انبارگردان تنخواه']);

        #1.admin site
        $user = 'App\User'::findOrFail(1);
        $user->assignRole($admin->name);
        #2.followUpManager
        $user = 'App\User'::findOrFail(2);
        $user->assignRole($followUpManager->name);
        #3.mainwarehouser
        $user = 'App\User'::findOrFail(3);
        $user->assignRole($mainwarehouser->name);
        #4.fundwarehouser
        $user = 'App\User'::findOrFail(4);
        $user->assignRole($fundwarehouser->name);
        #5.agentChief
        $user = 'App\User'::findOrFail(5);
        $user->assignRole($agentChief->name);
        #6.agent
        $user = 'App\User'::findOrFail(6);
        $user->assignRole($agent->name);
        #7.seller
        $user = 'App\User'::findOrFail(7);
        $user->assignRole($seller->name);
    }
}
