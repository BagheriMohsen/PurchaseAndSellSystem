<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\User;

use App\Models\State;
use App\Models\City;
use App\Models\Warehouse;
use App\Models\PaymentStatus;
use App\Models\Transport;
use App\Models\OrderStatus;
use App\Models\StoreRoomStatus;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Order;
use App\Models\OrderProduct;

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
        State::create([
            'name'    =>  'قم',
        ]);
        /*
        |--------------------------------------------------------------------------
        | Create City
        |--------------------------------------------------------------------------
        |*/
        City::create([
            'name'      => 'قم',
            'state_id'  =>  1
          ]);
        
        /*
        |--------------------------------------------------------------------------
        | Create Users
        |--------------------------------------------------------------------------
        |*/
        #1.create user for admin site
        User::create([
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
        User::create([
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
          User::create([
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
          User::create([
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
          #5.create agentChief
          User::create([
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
          
            'percent'       =>  null,
            
          ]);
          #6.create agent
          User::create([
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
            'sendAuto'      =>  'on',
            'backToWareHouse'    =>  null,
            'callCenter'    =>  null,
            'agent_id'      =>  5,
         
            'percent'       =>  null,
          
          ]);
          #7.create seller
          User::create([
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
            'porsantSeller' =>  1000,
            'percent'       =>  null,
           
          ]);
          #8.create callCenter
          User::create([
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
           
            'percent'       =>  null,
           
          ]);
        /*
        |--------------------------------------------------------------------------
        | Create WareHouse
        |--------------------------------------------------------------------------
        |*/
        #1
          Warehouse::create([
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
        Warehouse::create([
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
      PaymentStatus::create(['name'=>"پرداخت نماینده-بررسی نشده",]);
      PaymentStatus::create(['name'=>"پرداخت نماینده-تایید شده",]);
      PaymentStatus::create(['name'=>"پرداخت نماینده-تایید نشده",]);
      PaymentStatus::create(['name'=>"هزینه نماینده-بررسی نشده",]);
      PaymentStatus::create(['name'=>"هزینه نماینده-تایید شده",]);
      PaymentStatus::create(['name'=>"هزینه نماینده-تایید نشده",]);
      /*
      |--------------------------------------------------------------------------
      | Create Transport
      |--------------------------------------------------------------------------
      |*/
      Transport::create(['name'=>"اتوبوس رانی",]);
      Transport::create(['name'=>"باربری",]);
      Transport::create(['name'=>"تاکسیرانی",]);
      Transport::create(['name'=>"تحویل به نماینده",]);
      // Transport::create(['name'=>"پیک",]);
      // Transport::create(['name'=>"شکوه مهر",]);
      // Transport::create(['name'=>"چابک",]);
      // Transport::create(['name'=>"فارس پست",]);
      // Transport::create(['name'=>"فلوکس",]);
      // Transport::create(['name'=>"فروتل",]);
      // Transport::create(['name'=>"سپیده ماهان",]);
      // Transport::create(['name'=>"گیتوی پست",]);
      // Transport::create(['name'=>"لجیتو",]);
      /*
      |--------------------------------------------------------------------------
      | Create Order Status
      |--------------------------------------------------------------------------
      |*/
      OrderStatus::create(['name'=>'ثبت سفارش']);
      OrderStatus::create(['name'=>'ارسال به کالسنتر']);
      OrderStatus::create(['name'=>'ارسال به مدیر پیگیری']);
      OrderStatus::create(['name'=>'ارسال به فروشنده']);
      OrderStatus::create(['name'=>'تماس مجدد']);
      OrderStatus::create(['name'=>'برگشت به فروشنده']);
      OrderStatus::create(['name'=>'در انتظار تحویل']);
      OrderStatus::create(['name'=>'برگشت به مدیر پیگیری']);
      OrderStatus::create(['name'=>'غیر قابل ارسال']);
      OrderStatus::create(['name'=>'تحویل به مشتری-داخل شهر']);
      OrderStatus::create(['name'=>'تحویل به مشتری-حومه شهر']);
      OrderStatus::create(['name'=>'تحویل به مشتری-روستا']);
      OrderStatus::create(['name'=>'انصراف مشتری']);
      OrderStatus::create(['name'=>'معلق']);
      OrderStatus::create(['name'=>'وصول شده']);
      OrderStatus::create(['name'=>'انصراف نهایی']);
      OrderStatus::create(['name'=>'خام']);
      /*
      |--------------------------------------------------------------------------
      | Store Room Status
      |--------------------------------------------------------------------------
      |*/
      StoreRoomStatus::create(['name'=>'ورودی به انبار مادر']);
      StoreRoomStatus::create(['name'=>'ارسال به انبار تنخواه']);
      StoreRoomStatus::create(['name'=>'خروجی از انبار مادر']);
      StoreRoomStatus::create(['name'=>'مرجوعی از انبار تنخواه']);
      StoreRoomStatus::create(['name'=>'ورود از انبار مرکزی-پذیرفته نشده']);
      StoreRoomStatus::create(['name'=>'ورود از انبار مرکزی-پذیرفته شده']);
      StoreRoomStatus::create(['name'=>'ارسال به نماینده']);
      StoreRoomStatus::create(['name'=>'انبار به انبار نماینده']);
      StoreRoomStatus::create(['name'=>'برگشت به انبار مادر-تایید نشده']);
      StoreRoomStatus::create(['name'=>'ورودی به انبار نماینده-پذیرفته نشده']);
      StoreRoomStatus::create(['name'=>'ورودی به انبار نماینده-پذیرفته شده']);
      StoreRoomStatus::create(['name'=>'خروجی از انبار نماینده']);
      StoreRoomStatus::create(['name'=>'برگشت به انبار تنخواه-تایید نشده']);
      StoreRoomStatus::create(['name'=>'تحویل به مشتری']);
      StoreRoomStatus::create(['name'=>'مرجوعی از انبار تنخواه-تایید نشده']);
      StoreRoomStatus::create(['name'=>'مرجوعی از انبار تنخواه-تایید نشده']);
      StoreRoomStatus::create(['name'=>'برگشت به انبار تنخواه-تایید شده']);

    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    |*/
    Product::create([
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
    ProductType::create([
      'user_id'     =>  1,
      'product_id'  =>  1,
      'name'        =>  'شب'
    ]);
    ProductType::create([
      'user_id'     =>  1,
      'product_id'  =>  1,
      'name'        =>  'روز'
    ]);
    /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    |*/
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
  OrderProduct::create([
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
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
    OrderProduct::create([
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
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
  OrderProduct::create([
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
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
  OrderProduct::create([
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
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
  OrderProduct::create([
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
    $order = Order::create([
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
      'instant'           =>      'IsNot',
      'sellerDescription' =>      '5455454',
      'postalCode'        =>      '73737373',
      'address'           =>      'address',
      'HBD_Date'          =>      null,
      'delivary_Date'    =>      Carbon::now()
  ]);
    OrderProduct::create([
      'order_id'      =>  $order->id,
      'product_id'    =>  1,
      'count'         =>  5,
      'off'           =>  400,
      'product_type'  =>  1
  ]);
  OrderProduct::create([
    'order_id'      =>  $order->id,
    'product_id'    =>  1,
    'count'         =>  5,
    'off'           =>  400,
    'product_type'  =>  1
  ]);


    }
    


}
