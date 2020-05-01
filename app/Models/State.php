<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\City;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Order;

class State extends Model
{
    protected $fillable = [
      'name',
      'followUpManager'
    ];
    /*
    |--------------------------------------------------------------------------
    | Relation with City Model
    |--------------------------------------------------------------------------
    */
    public function cities(){
      return $this->hasMany(City::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with WareHouse Model
    |--------------------------------------------------------------------------
    */
    public function Warehouses(){
      return $this->hasMany(Warehouse::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with User Model
    |--------------------------------------------------------------------------
    */
    public function users(){
      return $this->hasMany(User::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relation with User Model
    |--------------------------------------------------------------------------
    */  
    public function followUpManager(){
      return $this->belongsTo(User::class, 'followUpManager','id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
      return $this->hasMany(Order::class);
    }
}
