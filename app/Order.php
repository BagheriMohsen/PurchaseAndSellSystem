<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use App\OrderProduct;
use App\OrderStatus;
use App\City;
use App\State;
use App\User;
use App\MoneyCirculation;

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
    'trackingCode',
    'transport_id',
    'isPaid',
    'PaidConfirm',
    'payDate',
    'suspended_Date',
    'delivary_Date',
    'collected_Date',
    'cancelled_Date',
    'returnToSeller_Date',
    'edit_Date',
    'send_seller_Date',
    'send_callcenter_Date',
    'returnToManager_Date',
    'allotment_Date',
    'product_array'
   ];
    /*
    |--------------------------------------------------------------------------
    | Releate to pivot order and product table
    |--------------------------------------------------------------------------
    |*/
    public function products(){
        return $this->hasMany(OrderProduct::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Releation with ProductStatus Model
    |--------------------------------------------------------------------------
    */
    public function OrderStatus(){
        return $this->belongsTo(OrderStatus::class,'status','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function city(){
        return $this->belongsTo(City::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
        return $this->belongsTo(State::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function agent(){
        return $this->belongsTo(User::class,'agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function followUpManager(){
        return $this->belongsTo(User::class,'followUpManager_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function callCenter(){
        return $this->belongsTo(User::class,'callCenter_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with MoneyCirculation Model 
    |--------------------------------------------------------------------------
    |*/
    public function MoneyCirculations(){
        return $this->hasMany(MoneyCirculation::class);
    }

}
