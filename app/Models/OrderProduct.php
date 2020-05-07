<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Order;
use App\Models\ProductType;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    
    protected $fillable = [
        'order_id',
        'product_id',
        'product_type',
        'count',
        'off',
        'collected',
        'cancelled'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relation to Product table
    |--------------------------------------------------------------------------
    |*/
    public function product(){
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation to Order table
    |--------------------------------------------------------------------------
    |*/
    public function order(){
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation to Product Type table
    |--------------------------------------------------------------------------
    |*/
    public function type(){
        return $this->belongsTo(ProductType::class, 'product_type','id');
    }
}
