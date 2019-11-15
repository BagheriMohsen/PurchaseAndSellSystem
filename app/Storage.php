<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = "storage";
    protected $fillable = [
        'user_id',
        'agent_id',
        'product_id',
        'warehouse_id',
        'number'
    ];
    /*
    |--------------------------------------------------------------------------
    | Realte With Product Model
    |--------------------------------------------------------------------------
    |*/
    public function product(){
        return $this->belongsTo('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With User Model - user_id
    |--------------------------------------------------------------------------
    |*/
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With User Model - agent_id
    |--------------------------------------------------------------------------
    |*/
    public function agent(){
        return $this->belongsTo('App\User','agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With Warehouse Model
    |--------------------------------------------------------------------------
    |*/
    public function warehouse(){
        return $this->belongsTo('App\Warehouse');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With StoreRoom Model
    |--------------------------------------------------------------------------
    |*/
    public function storeRoom(){
        return $this->hasMany('App\StoreRoom');
    }
}
