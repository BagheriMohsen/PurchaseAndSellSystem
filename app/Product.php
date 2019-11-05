<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'name',
      'code',
      'image',
      'price',
      'buyPrice',
      'description',
      'status',
      'messageStatus'

    ];
    // releation with ProductType Model
    public function types(){
      return $this->hasMany('App\ProductType');
    }


    // releate with SpecialTariff
    public function tariffs(){
      return $this->hasMany('App\SpecialTariff');
    }


}
