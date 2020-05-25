<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\MoneyCirculation;

class OrderStatus extends Model
{
    protected $table= 'order_statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | Relation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
        return $this->hasMany(Order::class, 'status','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with MoneyCirculation Model
    |--------------------------------------------------------------------------
    |*/
    public function MoneyCirculation(){
        return $this->hasMany(MoneyCirculation::class, 'order_status_id','id');
    }
}
