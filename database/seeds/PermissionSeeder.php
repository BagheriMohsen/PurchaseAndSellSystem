<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | CRUD Products
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read products','guard_name'=>'web','persianName'=>'مشاهده محصولات']);
        Permission::create(['name' => 'write product','guard_name'=>'web','persianName'=>'ایجاد محصول']);
        Permission::create(['name' => 'edit product','guard_name'=>'web','persianName'=>'ویرایش محصول']);
        Permission::create(['name' => 'delete product','guard_name'=>'web','persianName'=>'حذف محصول']);
        /*
        |--------------------------------------------------------------------------
        | CRUD warehouse
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read warehouse','guard_name'=>'web','persianName'=>'مشاهده انبارها']);
        Permission::create(['name' => 'write warehouse','guard_name'=>'web','persianName'=>'ایجاد انبار']);
        Permission::create(['name' => 'edit warehouse','guard_name'=>'web','persianName'=>'ویرایش انبار']);
        Permission::create(['name' => 'delete warehouse','guard_name'=>'web','persianName'=>'حذف انبار']);
        /*
        |--------------------------------------------------------------------------
        | CRUD mainWarehouser
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read mainWarehouser','guard_name'=>'web','persianName'=>'مشاهده موجودی انبار مادر']);
        Permission::create(['name' => 'write mainWarehouser','guard_name'=>'web','persianName'=>'افزودن موجودی انبار مادر']);
        Permission::create(['name' => 'edit mainWarehouser','guard_name'=>'web','persianName'=>'ویرایش موجودی انبار مادر']);
        Permission::create(['name' => 'delete mainWarehouser','guard_name'=>'web','persianName'=>'حذف و پاک کردن موجودی انبار مادر']);
        /*
        |--------------------------------------------------------------------------
        | CRUD fundWarehouser
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read fundWarehouser','guard_name'=>'web','persianName'=>'مشاهده موجودی انبار تنخواه']);
        /*
        |--------------------------------------------------------------------------
        | CRUD Users
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read users','guard_name'=>'web','persianName'=>'مشاهده کاربران']);
        Permission::create(['name' => 'write user','guard_name'=>'web','persianName'=>'ایجاد اکانت']);
        Permission::create(['name' => 'edit user','guard_name'=>'web','persianName'=>'ویرایش کاربر']);
        Permission::create(['name' => 'delete user','guard_name'=>'web','persianName'=>'حذف کاربر']);
        /*
        |--------------------------------------------------------------------------
        | CRUD City
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read cities','guard_name'=>'web','persianName'=>'مشاهده شهرها']);
        Permission::create(['name' => 'write city','guard_name'=>'web','persianName'=>'ایجاد شهر']);
        Permission::create(['name' => 'edit city','guard_name'=>'web','persianName'=>'ویرایش شهر']);
        Permission::create(['name' => 'delete city','guard_name'=>'web','persianName'=>'حذف شهر']);
        /*
        |--------------------------------------------------------------------------
        | CRUD State
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'read states','guard_name'=>'web','persianName'=>'مشاهده استانها']);
        Permission::create(['name' => 'write state','guard_name'=>'web','persianName'=>'ایجاد استان']);
        Permission::create(['name' => 'edit state','guard_name'=>'web','persianName'=>'ویرایش استان']);
        Permission::create(['name' => 'delete state','guard_name'=>'web','persianName'=>'حذف استان']);
        
    }
}
