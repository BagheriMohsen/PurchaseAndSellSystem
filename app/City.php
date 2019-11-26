<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
      'name',
      'state_id',
      'followUpManager'
    ];

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
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function followUpManager(){
      return $this->belongsTo('App\User','followUpManager','id');
    }
}
