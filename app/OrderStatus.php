<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table= 'order_statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
        return $this->hasMany('App\Order','status','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with MoneyCirculation Model
    |--------------------------------------------------------------------------
    |*/
    public function MoneyCirculation(){
        return $this->hasMany('App\MoneyCirculation','order_status_id','id');
    }
}
