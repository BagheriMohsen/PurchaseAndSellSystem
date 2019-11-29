<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
      'name',
      'state_id',
     
    ];
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
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
      return $this->belongsTo('App\State');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with warehouse Model
    |--------------------------------------------------------------------------
    */
    public function warehouses(){
      return $this->hasMany('App\Warehouse');
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
