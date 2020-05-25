<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Models\MoneyCirculation;
use App\Models\User;

class UserInventory extends Model
{
    protected $table = 'users_inventory';
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
        return $this->hasMany(MoneyCirculation::class, 'user_inventory_id','id');
    }
     /*
    |--------------------------------------------------------------------------
    | Releate with User Model - agent
    |--------------------------------------------------------------------------
    |*/
    public function agent(){
        return $this->belongsTo(User::class, 'agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with User Model - seller
    |--------------------------------------------------------------------------
    |*/
    public function seller(){
        return $this->belongsTo(User::class, 'seller_id','id');
    }
}
