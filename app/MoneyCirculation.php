<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyCirculation extends Model
{
    protected $fillable =[
        'user_inventory_id',
        'agent_id',
        'seller_id',
        'order_status_id',
        'order_id',
        'amount',
        'sharedSpecialAmount',
        'paymentStatus',
        'adminConfirm',
        'code',
        'trackingCode',
        'payDate'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releate with UserInventory Model
    |--------------------------------------------------------------------------
    |*/
    public function UserInventory(){
        return $this->belongsTo('App\UserInventory','user_inventory_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - agent
    |--------------------------------------------------------------------------
    |*/
    public function agent(){
        return $this->belongsTo('App\User','agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - seller
    |--------------------------------------------------------------------------
    |*/
    public function seller(){
        return $this->belongsTo('App\User','seller_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - Orderstatus
    |--------------------------------------------------------------------------
    |*/
    public function status(){
        return $this->belongsTo('App\OrderStatus','order_status_id','id');
    }


}
