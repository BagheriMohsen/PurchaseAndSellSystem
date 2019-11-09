<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name'=>'user','persianName'=>'کاربر عادی']);
        $role = Role::create(['name'=>'agent','persianName'=>'نماینده']);
        $role = Role::create(['name'=>'agentChief','persianName'=>'مدیر نماینده']);
        $role = Role::create(['name'=>'seller','persianName'=>'فروشنده']);
        $role = Role::create(['name'=>'warehouser','persianName'=>'انباردار']);
        $role = Role::create(['name'=>'followUpManager','persianName'=>'مدیر پیگیری']);
        $role = Role::create(['name'=>'admin','persianName'=>'ادمین سایت']);
        /*
        |--------------------------------------------------------------------------
        | CRUD Products
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read products','guard_name'=>'web']);
        $permissionWrite    = Permission::create(['name' => 'write product','guard_name'=>'web']);
        $permissionEdit     = Permission::create(['name' => 'edit product','guard_name'=>'web']);
        $permissionDelete   = Permission::create(['name' => 'delete product','guard_name'=>'web']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        /*
        |--------------------------------------------------------------------------
        | CRUD Users
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read users','guard_name'=>'web']);
        $permissionWrite    = Permission::create(['name' => 'write user','guard_name'=>'web']);
        $permissionEdit     = Permission::create(['name' => 'edit user','guard_name'=>'web']);
        $permissionDelete   = Permission::create(['name' => 'delete user','guard_name'=>'web']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        /*
        |--------------------------------------------------------------------------
        | CRUD City
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read cities','guard_name'=>'web']);
        $permissionWrite    = Permission::create(['name' => 'write city','guard_name'=>'web']);
        $permissionEdit     = Permission::create(['name' => 'edit city','guard_name'=>'web']);
        $permissionDelete   = Permission::create(['name' => 'delete city','guard_name'=>'web']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        /*
        |--------------------------------------------------------------------------
        | CRUD State
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read states','guard_name'=>'web']);
        $permissionWrite    = Permission::create(['name' => 'write state','guard_name'=>'web']);
        $permissionEdit     = Permission::create(['name' => 'edit state','guard_name'=>'web']);
        $permissionDelete   = Permission::create(['name' => 'delete state','guard_name'=>'web']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        
        $user = 'App\User'::findOrFail(1);
        $user->assignRole($role->name);
    }
}
