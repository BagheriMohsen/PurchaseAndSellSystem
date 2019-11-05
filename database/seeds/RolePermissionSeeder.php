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
        $role = Role::create(['name'=>'user','persianName' => 'کاربر عادی']);
        $role = Role::create(['name'=>'seller','persianName' => 'فروشنده']);
        $role = Role::create(['name'=>'warehouser','persianName' => 'انبار دار']);
        $role = Role::create(['name'=>'followUpManager','persianName' => 'مدیر پیگیری']);
        $role = Role::create(['name'=>'admin','persianName' => 'ادمین کل']);
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
        | CRUD Users
        |--------------------------------------------------------------------------
        */
        $permissionRead     = Permission::create(['name' => 'read users','guard_name'=>'web','persianName'=>'مشاهده کاربران']);
        $permissionWrite    = Permission::create(['name' => 'write user','guard_name'=>'web','persianName'=>'ایجاد کاربر']);
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
        
        $user = 'App\User'::findOrFail(1);
        $user->assignRole($role->name);
    }
}
