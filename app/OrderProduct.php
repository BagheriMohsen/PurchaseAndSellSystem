<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    
    protected $fillable = [
        'order_id',
        'product_id',
        'product_type',
        'count',
        'off'
    ];

    /*
    |--------------------------------------------------------------------------
    | Releate to Product table
    |--------------------------------------------------------------------------
    |*/
    public function product(){
        return $this->belongsTo('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate to Order table
    |--------------------------------------------------------------------------
    |*/
    public function order(){
        return $this->belongsTo('App\Order');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate to Product Type table
    |--------------------------------------------------------------------------
    |*/
    public function type(){
        return $this->belongsTo('App\ProductType','product_type','id');
    }
}
