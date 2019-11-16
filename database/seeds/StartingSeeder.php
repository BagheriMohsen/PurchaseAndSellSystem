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
        | Create City
        |--------------------------------------------------------------------------
        |*/
        'App\City'::create([
            'name' => 'قم'
          ]);
        /*
        |--------------------------------------------------------------------------
        | Create State
        |--------------------------------------------------------------------------
        |*/
        'App\State'::create([
            'name'    =>  'قم',
            'city_id' =>  1
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
            'callCenter'    =>  null,
            'agent_id'      =>  null,
            'porsantSeller' =>  '12',
            'percent'       =>  null,
            'locallyPrice'  =>  null,
            'internalPrice' =>  null,
            'villagePrice'  =>  null
          ]);
          #8.create seller
          'App\User'::create([
            'name'          =>  'حمیدرضا',
            'family'        =>  'رجبی',
            'sex'           =>  1,
            'username'      =>  'callCenter',
            'password'      =>  Hash::make('admin2020'),
            'mobile'        =>  '09106769465',
            'status'        =>  1,
            'state_id'      =>  1,
            'address'       =>  'Qom',
            'uploadCS'      =>  'some file',
            'level'         =>  'S',
            'sendAuto'      =>  0,
            'reciveAuto'    =>  1,
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
            'user_id'       =>  1,
            'name'          =>  "انبار مادر",
            'city_id'       =>  1,
            'description'   =>  "",
            'address'       =>  "قم-خیابان ارم",
            'telephon'      =>  "",
            'postalCard'    =>  "" 
        ]);
        #2
        'App\Warehouse'::create([
          'user_id'       =>  1,
          'name'          =>  "انبار تنخواه",
          'city_id'       =>  1,
          'description'   =>  "",
          'address'       =>  "قم-خیابان ارم",
          'telephon'      =>  "",
          'postalCard'    =>  "" 
      ]);
      /*
      |--------------------------------------------------------------------------
      | Create Transport
      |--------------------------------------------------------------------------
      |*/
      #1
      'App\Transport'::create([
        'name'          =>  "اتوبوس رانی",
      ]);
      #2
      'App\Transport'::create([
        'name'          =>  "باربری",
      ]);
      #3
      'App\Transport'::create([
        'name'          =>  "تاکسیرانی",
      ]);
      #4
      'App\Transport'::create([
        'name'          =>  "تحویل به نماینده",
      ]);

      
    }
}
