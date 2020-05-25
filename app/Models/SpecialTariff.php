<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Product;

class SpecialTariff extends Model
{
    protected $fillable = [
      'user_id',
      'product_id',
      'place',
      'price'
    ];


    /*
    |--------------------------------------------------------------------------
    | Relation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
      return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
      return $this->belongsTo(Product::class);
    }
}
