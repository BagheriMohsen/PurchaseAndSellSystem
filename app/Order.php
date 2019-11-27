<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
    'city_id',
    'state_id',
    'status',
    'lastStatus',
    'seller_id',
    'agent_id',
    'callCenter_id',
    'followUpManager_id',
    'pay_id',
    'mobile',
    'telephone',
    'fullName',
    'paymentMethod',
    'shippingCost',
    'prePayment',
    'cashPrice',
    'chequePrice',
    'instant',
    'sellerDescription',
    'sendDescription',
    'postalCode',
    'address',
    'addressConfirm',
    'HBD_Date',
   
   ];
    /*
    |--------------------------------------------------------------------------
    | Releate to pivot order and product table
    |--------------------------------------------------------------------------
    |*/
    public function products(){
        return $this->hasMany('App\OrderProduct');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with ProductStatus Model
    |--------------------------------------------------------------------------
    */
    public function status(){
        return $this->belongsTo('App\OrderStatus');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function city(){
        return $this->belongsTo('App\City');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
        return $this->belongsTo('App\State');
    }

}
