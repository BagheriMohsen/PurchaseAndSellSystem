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
        | Create User
        |--------------------------------------------------------------------------
        |*/
        'App\User'::create([
            'name'          =>  'محسن',
            'family'        =>  'باقری',
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
          return redirect()->route('users.index');
    }
}
