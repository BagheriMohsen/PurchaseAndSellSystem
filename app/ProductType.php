<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
      'user_id',
      'product_id',
      'name'
    ];

    //releation with product model
    public function product(){
      return $this->belongsTo('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate to OrderProduct Type table
    |--------------------------------------------------------------------------
    |*/
    public function type(){
      return $this->hasMany('App\OrderProduct','product_type','id');
  }
}
