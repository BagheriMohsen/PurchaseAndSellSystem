<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


use App\Models\StoreRoom;
use App\Models\City;
use App\Models\State;
use App\Models\User;

class Warehouse extends Model
{
    use Sluggable;
    protected $fillable = [
        'user_id',
        'state_id',
        'city_id',
        'name',
        'slug',
        'description',
        'telephone',
        'postalCard',
        'address'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function storeRooms(){
        return $this->hasMany(StoreRoom::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function city(){
        return $this->belongsTo(City::class, 'city_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
        return $this->belongsTo(State::class, 'state_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
