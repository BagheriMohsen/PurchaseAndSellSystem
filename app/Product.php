<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Cviebrock\EloquentSluggable\Sluggable;
class Product extends Model implements HasMedia
{

    use HasMediaTrait;
    use Sluggable;
    protected $fillable = [
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
    | Releation with ProductOff Model
    |--------------------------------------------------------------------------
    */
    public function offs(){
        return $this->hasMany('App\ProductOff');
      }
    /*
    |--------------------------------------------------------------------------
    | Releation with ProductType Model
    |--------------------------------------------------------------------------
    */
    public function types(){
      return $this->hasMany('App\ProductType');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with SpecialTariff
    |--------------------------------------------------------------------------
    */
    public function tariffs(){
      return $this->hasMany('App\SpecialTariff');
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
