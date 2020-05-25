<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Cviebrock\EloquentSluggable\Sluggable;


use App\Models\OrderProduct;
use App\Models\Storage;
use App\Models\StoreRoom;
use App\Models\ProductOff;
use App\Models\ProductType;
use App\Models\SpecialTariff;

class Product extends Model implements HasMedia
{

    use HasMediaTrait;
    use Sluggable;

    
    protected $fillable = [
      'user_id',
      'name',
      'slug',
      'code',
      'image_id',
      'price',
      'buyPrice',
      'description',
      'status',
      'messageStatus'

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
    | Relation to pivot order and product table
    |--------------------------------------------------------------------------
    |*/
    public function orders(){
        return $this->hasMany(OrderProduct::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation With Storage Model
    |--------------------------------------------------------------------------
    |*/
    public function storage(){
        return $this->hasMany(Storage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function storeRooms(){
        return $this->hasMany(StoreRoom::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with ProductOff Model
    |--------------------------------------------------------------------------
    */
    public function offs(){
        return $this->hasMany(ProductOff::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with ProductType Model
    |--------------------------------------------------------------------------
    */
    public function types(){
      return $this->hasMany(ProductType::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with SpecialTariff
    |--------------------------------------------------------------------------
    */
    public function tariffs(){
      return $this->hasMany(SpecialTariff::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Conversion image with Media Model
    |--------------------------------------------------------------------------
    */
    public function registerMediaCollections()
    {
        
        //Thumb image for Product
        $this->addMediaConversion('thumb')
              ->width(75)
              ->height(75);
        //Card image for Product
        $this->addMediaConversion('card')
            ->width(400)
            ->height(400);
    }
    /*
    |--------------------------------------------------------------------------
    | Relate with Media Model
    |--------------------------------------------------------------------------
    */
    public function productImage(){
        return $this->hasOne(Media::class,'id','image_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Card url in view page
    |--------------------------------------------------------------------------
    */
    public function getCardUrlAttribute(){
        return $this->productImage->getUrl('card');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Thumb url in view page
    |--------------------------------------------------------------------------
    */
    public function getThumbUrlAttribute(){
        return $this->productImage->getUrl('thumb');
    }


}
