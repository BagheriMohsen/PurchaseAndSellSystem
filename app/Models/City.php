<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\State;
use App\Models\Warehouse;
use App\Models\Order;

class City extends Model
{
    protected $fillable = [
      'name',
      'state_id',
     
    ];

    /*
    |--------------------------------------------------------------------------
    | Realtion with User Model
    |--------------------------------------------------------------------------
    */
    public function users(){
      return $this->hasMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Realtion with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
      return $this->belongsTo(State::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Realtion with warehouse Model
    |--------------------------------------------------------------------------
    */
    public function warehouses(){
      return $this->hasMany(Warehouse::class);
    }
   
    /*
    |--------------------------------------------------------------------------
    | Realtion with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
      return $this->hasMany(Order::class);
    }
}
