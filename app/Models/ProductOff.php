<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class ProductOff extends Model
{
    
    protected $fillable = [
        'user_id',
        'product_id',
        'offPrice',
        'numberOfProduct'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo(Product::class);
      }
}
