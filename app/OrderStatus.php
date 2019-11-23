<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table= 'order_statuses';
    protected $fillable = [
        'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orders(){
        return $this->hasMany('App\Order');
    }
}
