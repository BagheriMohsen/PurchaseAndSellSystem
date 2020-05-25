<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\OrderProduct;

class ProductType extends Model
{
    protected $fillable = [
      'user_id',
      'product_id',
      'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | Relation with product model
    |--------------------------------------------------------------------------
    |*/
    public function product(){
      return $this->belongsTo(Product::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relation to OrderProduct Type table
    |--------------------------------------------------------------------------
    |*/
    public function type(){
      return $this->hasMany(OrderProduct::class, 'product_type','id');
  }
}
