<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\UserInventory;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Order;

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
    | Relation with UserInventory Model
    |--------------------------------------------------------------------------
    |*/
    public function UserInventory(){
        return $this->belongsTo(UserInventory::class,'user_inventory_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with User Model - agent
    |--------------------------------------------------------------------------
    |*/
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relation with User Model - Orderstatus
    |--------------------------------------------------------------------------
    |*/
    public function status(){
        return $this->belongsTo(OrderStatus::class, 'order_status_id','id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relation with Order Model 
    |--------------------------------------------------------------------------
    |*/
    public function order(){
        return $this->belongsTo(Order::class);
    }


}
