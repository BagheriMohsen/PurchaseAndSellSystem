<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
      'name'
    ];

    /*
    |--------------------------------------------------------------------------
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function states(){
      return $this->hasMany('App\State');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with warehouse Model
    |--------------------------------------------------------------------------
    */
    public function warehouses(){
      return $this->hasMany('App\Warehouse');
  }
}
