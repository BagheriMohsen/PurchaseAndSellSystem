<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\StoreRoom;


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
        return $this->belongsTo(Product::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With User Model - user_id
    |--------------------------------------------------------------------------
    |*/
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With User Model - agent_id
    |--------------------------------------------------------------------------
    |*/
    public function agent(){
        return $this->belongsTo(User::class,'agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With Warehouse Model
    |--------------------------------------------------------------------------
    |*/
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Realte With StoreRoom Model
    |--------------------------------------------------------------------------
    |*/
    public function storeRoom(){
        return $this->hasMany(StoreRoom::class);
    }
}
