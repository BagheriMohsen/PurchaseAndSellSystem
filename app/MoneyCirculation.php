<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyCirculation extends Model
{
    protected $table = 'money_circulations';
    protected $fillable =[
        'user_inventory_id',
        'agent_id',
        'seller_id',
        'order_status_id',
        'order_product_id',
        'order_id',
        'amount',
        'sharedSpecialAmount',
        'code',
        'trackingCode',
       
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
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - Orderstatus
    |--------------------------------------------------------------------------
    |*/
    public function status(){
        return $this->belongsTo('App\OrderStatus','order_status_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with Order Model 
    |--------------------------------------------------------------------------
    |*/
    public function order(){
        return $this->belongsTo('App\Order');
    }


}
