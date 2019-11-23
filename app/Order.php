<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
    'city_id',
    'state_id',
    'status_id',
    'mobile',
    'telephone',
    'fullName',
    'paymentMethod',
    'sendCost',
    'prePrice',
    'checkPrice',
    'status',
    'description',
    'postalCode',
    'address',
    'HBD_Date',
   
   ];
    /*
    |--------------------------------------------------------------------------
    | Releate to pivot order and product table
    |--------------------------------------------------------------------------
    |*/
    public function products(){
        return $this->belongsToMany('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with ProductStatus Model
    |--------------------------------------------------------------------------
    */
    public function status(){
        return $this->belongsTo('App\OrderStatus');
    }

}
