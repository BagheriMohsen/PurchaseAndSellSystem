<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInventory extends Model
{
    protected $fillable = [
        'seller_id',
        'agent_id',
        'balance',
        'debtor',
        'Creditor'
    ];

    /*
    |--------------------------------------------------------------------------
    | Releate with MoneyCirculation Model
    |--------------------------------------------------------------------------
    |*/
    public function MoneyCirculations(){
        return $this->hasMany('App\MoneyCirculation','user_inventory_id','id');
    }
     /*
    |--------------------------------------------------------------------------
    | Releate with User Model - agent
    |--------------------------------------------------------------------------
    |*/
    public function agent(){
        return $this->belongsTo('App\User','agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - seller
    |--------------------------------------------------------------------------
    |*/
    public function seller(){
        return $this->belongsTo('App\User','seller_id','id');
    }
}
