<?php

use Illuminate\Database\Seeder;

class StartingSeeder extends Seeder
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
        'App\State'::create([
            'name'    =>  'قم',
        ]);
        /*
        |--------------------------------------------------------------------------
        | Create City
        |--------------------------------------------------------------------------
        |*/
        'App\City'::create([
            'name'      => 'قم',
            'state_id'  =>  1
          ]);
        
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
          ]); 
          #5.create agentChief
          'App\User'::create([
            'name'          =>  'حمیدرضا',
            'family'        =>  'رجبی',
            'sex'           =>  1,
            'username'      =>  'agentChief',
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
          ]);
          #6.create agent
          'App\User'::create([
            'name'          =>  'حمیدرضا',
            'family'        =>  'رجبی',
            'sex'           =>  1,
            'username'      =>  'agent',
            'password'      =>  Hash::make('admin2020'),
            'mobile'        =>  '09106769465',
            'status'        =>  'on',
            'city_id'       =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  null,
            'backToWareHouse'    =>  null,
            'callCenter'    =>  null,
            'agent_id'      =>  5,
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
          ]);
          #7.create seller
          'App\User'::create([
            'name'          =>  'حمیدرضا',
            'family'        =>  'رجبی',
            'sex'           =>  1,
            'username'      =>  'seller',
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
          ]);
          #8.create callCenter
          'App\User'::create([
            'name'          =>  'حمیدرضا',
            'family'        =>  'رجبی',
            'sex'           =>  1,
            'username'      =>  'callCenter',
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
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
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
          'city_id'       =>  1,
          'description'   =>  "",
          'address'       =>  "قم-خیابان ارم",
          'telephone'      =>  "",
          'postalCard'    =>  "" 
      ]);
      /*
      |--------------------------------------------------------------------------
      | Create Transport
      |--------------------------------------------------------------------------
      |*/
      'App\Transport'::create(['name'=>"اتوبوس رانی",]);
      'App\Transport'::create(['name'=>"باربری",]);
      'App\Transport'::create(['name'=>"تاکسیرانی",]);
      'App\Transport'::create(['name'=>"تحویل به نماینده",]);
      // 'App\Transport'::create(['name'=>"پیک",]);
      // 'App\Transport'::create(['name'=>"شکوه مهر",]);
      // 'App\Transport'::create(['name'=>"چابک",]);
      // 'App\Transport'::create(['name'=>"فارس پست",]);
      // 'App\Transport'::create(['name'=>"فلوکس",]);
      // 'App\Transport'::create(['name'=>"فروتل",]);
      // 'App\Transport'::create(['name'=>"سپیده ماهان",]);
      // 'App\Transport'::create(['name'=>"گیتوی پست",]);
      // 'App\Transport'::create(['name'=>"لجیتو",]);
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
      'App\StoreRoomStatus'::create(['name'=>'خروجی از انبار تنخواه']);
      'App\StoreRoomStatus'::create(['name'=>'ورودی به انبار نماینده-پذیرفته نشده']);
      'App\StoreRoomStatus'::create(['name'=>'ورودی به انبار نماینده-پذیرفته شده']);
      'App\StoreRoomStatus'::create(['name'=>'خروجی از انبار نماینده']);
      'App\StoreRoomStatus'::create(['name'=>'برگشت به انبار تنخواه']);
      'App\StoreRoomStatus'::create(['name'=>'تحویل به مشتری']);
    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    |*/
    'App\Product'::create([
      'user_id'       =>  1,
      'name'          =>  'کرم',
      'code'          =>  2501,
      'price'         =>  10000,
      'buyPrice'      =>  9500,
      'description'   =>  'یک توضیح',
      'status'        =>  'on',
      'messageStatus' =>  'on',
    ]);
    /*
    |--------------------------------------------------------------------------
    | Store Product Type
    |--------------------------------------------------------------------------
    |*/
    'App\ProductType'::create([
      'user_id'     =>  1,
      'product_id'  =>  1,
      'name'        =>  'شب'
    ]);
    'App\ProductType'::create([
      'user_id'     =>  1,
      'product_id'  =>  1,
      'name'        =>  'روز'
    ]);
    /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
  'App\OrderProduct'::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
]);
    /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
    'App\OrderProduct'::create([
      'order_id'      =>  $order->id,
      'product_id'    =>  1,
      'count'         =>  5,
      'off'           =>  400,
      'product_type'  =>  1
  ]);
   /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
  'App\OrderProduct'::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
]);
   /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
  'App\OrderProduct'::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
]);
   /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
  'App\OrderProduct'::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
]);
   /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = 'App\Order'::create([
      'city_id'           =>      1,
      'state_id'          =>      1,
      'agent_id'          =>      6,
      'followUpManager_id'=>      2,
      'seller_id'         =>      7,
      'status'            =>      7,
      'lastStatus'        =>      1,
      'trackingCode'      =>      uniqid(),
      'mobile'            =>      '09106769465',
      'telephone'         =>      '02531616161',
      'fullName'          =>      'mohsen bagheri',
      'paymentMethod'     =>      'cash',
      'shippingCost'      =>      null,
      'prePayment'        =>      null,
      'cashPrice'         =>      null,
      'chequePrice'       =>      null,
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null
  ]);
    'App\OrderProduct'::create([
      'order_id'      =>  $order->id,
      'product_id'    =>  1,
      'count'         =>  5,
      'off'           =>  400,
      'product_type'  =>  1
  ]);
  'App\OrderProduct'::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
  ]);


    }
    


}
