<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'name',
      'followUpManager'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function cities(){
      return $this->hasMany('App\City');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with WareHouse Model
    |--------------------------------------------------------------------------
    */
    public function Warehouses(){
      return $this->hasMany('App\Warehouse');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function users(){
      return $this->hasMany('App\User');
    }
     /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function followUpManager(){
      return $this->belongsTo('App\User','followUpManager','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
      return $this->hasMany('App\Order');
    }
}
