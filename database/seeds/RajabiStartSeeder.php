<?php

use Illuminate\Database\Seeder;

class RajabiStartSeeder extends Seeder
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
        | Create State
        |--------------------------------------------------------------------------
        |*/
        // 'App\State'::create([
        //     'name'    =>  'قم',
        // ]);
        /*
        |--------------------------------------------------------------------------
        | Create City
        |--------------------------------------------------------------------------
        |*/
        // 'App\City'::create([
        //     'name'      => 'قم',
        //     'state_id'  =>  1
        //   ]);
        
        /*
        |--------------------------------------------------------------------------
        | Create Users
        |--------------------------------------------------------------------------
        |*/
        #1.create user for admin site
        'App\User'::create([
          'name'          =>  'حمیدرضا',
          'family'        =>  'رجبی',
          'sex'           =>  1,
          'username'      =>  'admin',
          'password'      =>  Hash::make('admin2020'),
          'mobile'        =>  '09106769465',
          'status'        =>  'on',
          'city_id'       =>  1,
          'state_id'      =>  1,
          'address'       =>  'Qom',
          'uploadCS'      =>  'some file',
          'level'         =>  null,
          'sendAuto'      =>  null,
          'backToWareHouse'    =>  null,
          'callCenter'    =>  null,
          'agent_id'      =>  null,
        
          'percent'       =>  null,
         
        ]);
      #2.create user for followUpManger
      'App\User'::create([
          'name'          =>  'حمیدرضا',
          'family'        =>  'رجبی',
          'sex'           =>  1,
          'username'      =>  'peygiri.sh',
          'password'      =>  Hash::make('admin2020'),
          'mobile'        =>  '09106769465',
          'status'        =>  'on',
          'city_id'       =>  1,
          'state_id'      =>  1,
          'address'       =>  'Qom',
          'uploadCS'      =>  'some file',
          'level'         =>  null,
          'sendAuto'      =>  null,
          'backToWareHouse'    =>  null,
          'callCenter'    =>  null,
          'agent_id'      =>  null,
   
          'percent'       =>  null,
          
        ]);
        #3.create user for mainWareHouse
        'App\User'::create([
          'name'          =>  'حمیدرضا',
          'family'        =>  'رجبی',
          'sex'           =>  1,
          'username'      =>  'anbar.m',
          'password'      =>  Hash::make('admin2020'),
          'mobile'        =>  '09106769465',
          'status'        =>  'on',
          'city_id'       =>  1,
          'state_id'      =>  1,
          'address'       =>  'Qom',
          'uploadCS'      =>  'some file',
          'level'         =>  null,
          'sendAuto'      =>  null,
          'backToWareHouse'    =>  null,
          'callCenter'    =>  null,
          'agent_id'      =>  null,
     
          'percent'       =>  null,
          
        ]);
        #4.create user for fundWareHouse
        'App\User'::create([
          'name'          =>  'حمیدرضا',
          'family'        =>  'رجبی',
          'sex'           =>  1,
          'username'      =>  'anbar.t',
          'password'      =>  Hash::make('admin2020'),
          'mobile'        =>  '09106769465',
          'status'        =>  'on',
          'city_id'       =>  1,
          'state_id'      =>  1,
          'address'       =>  'Qom',
          'uploadCS'      =>  'some file',
          'level'         =>  null,
          'sendAuto'      =>  null,
          'backToWareHouse'    =>  null,
          'callCenter'    =>  null,
          'agent_id'      =>  null,
         
          'percent'       =>  null,
       
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | Create WareHouse
        |--------------------------------------------------------------------------
        |*/
        #1
          'App\Warehouse'::create([
            'user_id'       =>  3,
            'name'          =>  "انبار مادر",
            'state_id'       =>  1,
            'city_id'       =>  1,
            'description'   =>  "",
            'address'       =>  "قم-خیابان ارم",
            'telephone'      =>  "",
            'postalCard'    =>  "" 
        ]);
        #2
        'App\Warehouse'::create([
          'user_id'       =>  4,
          'name'          =>  "انبار تنخواه",
          'state_id'       =>  1,
          'city_id'       =>  1,
          'description'   =>  "",
          'address'       =>  "قم-خیابان ارم",
          'telephone'      =>  "",
          'postalCard'    =>  "" 
      ]);
      /*
      |--------------------------------------------------------------------------
      | Create Payment Status
      |--------------------------------------------------------------------------
      |*/
      'App\PaymentStatus'::create(['name'=>"پرداخت نماینده-تایید نشده",]);
      'App\PaymentStatus'::create(['name'=>"پرداخت نماینده-تایید شده",]);
      /*
      |--------------------------------------------------------------------------
      | Create Transport
      |--------------------------------------------------------------------------
      |*/
      'App\Transport'::create(['name'=>"اتوبوس رانی",]);
      'App\Transport'::create(['name'=>"باربری",]);
      'App\Transport'::create(['name'=>"تاکسیرانی",]);
      'App\Transport'::create(['name'=>"تحویل به نماینده",]);
     
      /*
      |--------------------------------------------------------------------------
      | Create Order Status
      |--------------------------------------------------------------------------
      |*/
      'App\OrderStatus'::create(['name'=>'ثبت سفارش']);
      'App\OrderStatus'::create(['name'=>'ارسال به کالسنتر']);
      'App\OrderStatus'::create(['name'=>'ارسال به مدیر پیگیری']);
      'App\OrderStatus'::create(['name'=>'ارسال به فروشنده']);
      'App\OrderStatus'::create(['name'=>'تماس مجدد']);
      'App\OrderStatus'::create(['name'=>'برگشت به فروشنده']);
      'App\OrderStatus'::create(['name'=>'در انتظار تحویل']);
      'App\OrderStatus'::create(['name'=>'برگشت به مدیر پیگیری']);
      'App\OrderStatus'::create(['name'=>'غیر قابل ارسال']);
      'App\OrderStatus'::create(['name'=>'تحویل به مشتری-داخل شهر']);
      'App\OrderStatus'::create(['name'=>'تحویل به مشتری-حومه شهر']);
      'App\OrderStatus'::create(['name'=>'تحویل به مشتری-روستا']);
      'App\OrderStatus'::create(['name'=>'انصراف مشتری']);
      'App\OrderStatus'::create(['name'=>'معلق']);
      'App\OrderStatus'::create(['name'=>'وصول شده']);
      'App\OrderStatus'::create(['name'=>'انصراف نهایی']);
      'App\OrderStatus'::create(['name'=>'خام']);
      /*
      |--------------------------------------------------------------------------
      | Store Room Status
      |--------------------------------------------------------------------------
      |*/
      'App\StoreRoomStatus'::create(['name'=>'ورودی به انبار مادر']);
      'App\StoreRoomStatus'::create(['name'=>'ارسال به انبار تنخواه']);
      'App\StoreRoomStatus'::create(['name'=>'خروجی از انبار مادر']);
      'App\StoreRoomStatus'::create(['name'=>'مرجوعی از انبار تنخواه']);
      'App\StoreRoomStatus'::create(['name'=>'ورود از انبار مرکزی-پذیرفته نشده']);
      'App\StoreRoomStatus'::create(['name'=>'ورود از انبار مرکزی-پذیرفته شده']);
      'App\StoreRoomStatus'::create(['name'=>'ارسال به نماینده']);
      'App\StoreRoomStatus'::create(['name'=>'انبار به انبار نماینده']);
      'App\StoreRoomStatus'::create(['name'=>'برگشت به انبار مادر-تایید نشده']);
      'App\StoreRoomStatus'::create(['name'=>'ورودی به انبار نماینده-پذیرفته نشده']);
      'App\StoreRoomStatus'::create(['name'=>'ورودی به انبار نماینده-پذیرفته شده']);
      'App\StoreRoomStatus'::create(['name'=>'خروجی از انبار نماینده']);
      'App\StoreRoomStatus'::create(['name'=>'برگشت به انبار تنخواه']);
      'App\StoreRoomStatus'::create(['name'=>'تحویل به مشتری']);
      'App\StoreRoomStatus'::create(['name'=>'مرجوعی از انبار تنخواه-تایید نشده']);
    

    }
    


}
