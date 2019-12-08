<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RajabiRoleSeeder extends Seeder
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
        $callCenter         = Role::create(['name'=>'callCenter','persianName'=>'کالسنتر']);

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
       
    }
}
