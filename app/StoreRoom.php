<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreRoom extends Model
{
    protected $fillable = [
      'product_id',
      'user_id',
      'number',
      'in_out',
      'description',
      'in_date',
      'out_date'  
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Warehouse Model
    |--------------------------------------------------------------------------
    */
    public function Warehouse(){
        return $this->belongsTo('App\Warehouse');
    }
}
