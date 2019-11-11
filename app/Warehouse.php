<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Warehouse extends Model
{
    use Sluggable;
    protected $fillable = [
        'user_id',
        'city_id',
        'name',
        'slug',
        'description',
        'telephon',
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
        return $this->hasMany('App\StoreRoom');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function cities(){
        return $this->belongsTo('App\City','city_id','id');
    }
}
