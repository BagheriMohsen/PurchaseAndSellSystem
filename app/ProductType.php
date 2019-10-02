<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
      'product_id',
      'name'
    ];

    //releation with product model
    public function product(){
      return $this->belongsTo('App\Product');
    }
}
