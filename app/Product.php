<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
class Product extends Model implements HasMedia
{

    use HasMediaTrait;

    protected $fillable = [
      'name',
      'code',
      'image',
      'price',
      'buyPrice',
      'description',
      'status',
      'messageStatus'

    ];
    // releation with ProductType Model
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
        
        //Thumb image for Article
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(150);
        //Card image for Article
        $this->addMediaConversion('card')
            ->width(350)
            ->height(300);
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
        return $this->card->getUrl('card');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Thumb url in view page
    |--------------------------------------------------------------------------
    */
    public function getThumbUrlAttribute(){
        return $this->card->getUrl('thumb');
    }


}
