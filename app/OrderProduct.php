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
}
