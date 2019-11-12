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
        $role  = Role::create(['name'=>'user','persianName'=>'کاربر عادی']);
        $role  = Role::create(['name'=>'agent','persianName'=>'نماینده']);
        $role  = Role::create(['name'=>'agentChief','persianName'=>'مدیر نماینده']);
        $role  = Role::create(['name'=>'seller','persianName'=>'فروشنده']);
        $role  = Role::create(['name'=>'admin','persianName'=>'ادمین سایت']);
        /*
        |--------------------------------------------------------------------------
        | CRUD Products
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read products','guard_name'=>'web','persianName'=>'مشاهده محصولات']);
        $permissionWrite    = Permission::create(['name' => 'write product','guard_name'=>'web','persianName'=>'ایجاد محصول']);
        $permissionEdit     = Permission::create(['name' => 'edit product','guard_name'=>'web','persianName'=>'ویرایش محصول']);
        $permissionDelete   = Permission::create(['name' => 'delete product','guard_name'=>'web','persianName'=>'حذف محصول']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        /*
        |--------------------------------------------------------------------------
        | CRUD warehouse
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read warehouse','guard_name'=>'web','persianName'=>'مشاهده انبارها']);
        $permissionWrite    = Permission::create(['name' => 'write warehouse','guard_name'=>'web','persianName'=>'ایجاد انبار']);
        $permissionEdit     = Permission::create(['name' => 'edit warehouse','guard_name'=>'web','persianName'=>'ویرایش انبار']);
        $permissionDelete   = Permission::create(['name' => 'delete warehouse','guard_name'=>'web','persianName'=>'حذف انبار']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        /*
        |--------------------------------------------------------------------------
        | CRUD mainWarehouser
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read storeRoom','guard_name'=>'web','persianName'=>'مشاهده موجودی انبار']);
        $permissionWrite    = Permission::create(['name' => 'write storeRoom','guard_name'=>'web','persianName'=>'افزودن موجودی انبار']);
        $permissionEdit     = Permission::create(['name' => 'edit storeRoom','guard_name'=>'web','persianName'=>'ویرایش موجودی انبار']);
        $permissionDelete   = Permission::create(['name' => 'delete storeRoom','guard_name'=>'web','persianName'=>'حذف و پاک کردن موجودی انبار']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
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
        $permissionRead     = Permission::create(['name' => 'read users','guard_name'=>'web','persianName'=>'مشاهده کاربران']);
        $permissionWrite    = Permission::create(['name' => 'write user','guard_name'=>'web','persianName'=>'ایجاد اکانت']);
        $permissionEdit     = Permission::create(['name' => 'edit user','guard_name'=>'web','persianName'=>'ویرایش کاربر']);
        $permissionDelete   = Permission::create(['name' => 'delete user','guard_name'=>'web','persianName'=>'حذف کاربر']);
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
        $permissionRead     = Permission::create(['name' => 'read cities','guard_name'=>'web','persianName'=>'مشاهده شهرها']);
        $permissionWrite    = Permission::create(['name' => 'write city','guard_name'=>'web','persianName'=>'ایجاد شهر']);
        $permissionEdit     = Permission::create(['name' => 'edit city','guard_name'=>'web','persianName'=>'ویرایش شهر']);
        $permissionDelete   = Permission::create(['name' => 'delete city','guard_name'=>'web','persianName'=>'حذف شهر']);
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
        $permissionRead     = Permission::create(['name' => 'read states','guard_name'=>'web','persianName'=>'مشاهده استانها']);
        $permissionWrite    = Permission::create(['name' => 'write state','guard_name'=>'web','persianName'=>'ایجاد استان']);
        $permissionEdit     = Permission::create(['name' => 'edit state','guard_name'=>'web','persianName'=>'ویرایش استان']);
        $permissionDelete   = Permission::create(['name' => 'delete state','guard_name'=>'web','persianName'=>'حذف استان']);
        /*
        |--------------------------------------------------------------------------
        */
        $permissionWrite->assignRole($role);
        $permissionRead->assignRole($role);
        $permissionEdit->assignRole($role);
        $permissionDelete->assignRole($role); 
        #1.admin site
        $user = 'App\User'::findOrFail(1);
        $user->assignRole($role->name);
        #2.followUpManager
        $role  = Role::create(['name'=>'followUpManager','persianName'=>'مدیر پیگیری']);
        $user = 'App\User'::findOrFail(2);
        $user->assignRole($role->name);
        #3.mainwarehouser
        $role  = Role::create(['name'=>'mainWarehouser','persianName'=>'انبار مادر']);
        $user = 'App\User'::findOrFail(3);
        $user->assignRole($role->name);
        #4.fundwarehouser
        $role  = Role::create(['name'=>'fundWarehouser','persianName'=>'انبار تنخواه']);
        $user = 'App\User'::findOrFail(4);
        $user->assignRole($role->name);

    }
}
