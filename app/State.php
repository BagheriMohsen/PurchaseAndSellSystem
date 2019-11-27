<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'name'
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
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function users(){
      return $this->hasMany('App\User');
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
