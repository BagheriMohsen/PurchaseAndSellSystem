<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    | Releation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo('App\Product');
      }
}
