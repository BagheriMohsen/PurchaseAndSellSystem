<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialTariff extends Model
{
    protected $fillable = [
      'user_id',
      'product_id',
      'place',
      'price'
    ];


    // releate with user
    public function user(){
      return $this->belongsTo('App\User');
    }

    // releate with product
    public function product(){
      return $this->belongsTo('App\Product');
    }
}
