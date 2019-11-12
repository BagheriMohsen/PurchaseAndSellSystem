<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cog\Laravel\Ban\Traits\Bannable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use HasMediaTrait;
    use Bannable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id',
        'name',
        'family',
        'sex',
        'username',
        'password',
        'mobile',
        'status',
        'state_id',
        'address',
        'uploadCS',
        'level',
        'reciveAuto',
        'sendAuto',
        'callCenter',
        'agent_id',
        'porsantSeller',
        'percent',
        'calType',
        'locallyPrice',
        'internalPrice',
        'villagePrice',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
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
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
      return $this->belongsTo('App\State');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with ItSelf
    |--------------------------------------------------------------------------
    */
    public function chief()
    {
        return $this->belongsTo(User::class, 'agent_id');
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
        $this->addMediaConversion('avatar')
              ->width(50)
              ->height(50);
        //Card image for Article
        $this->addMediaConversion('card')
            ->width(250)
            ->height(250);
    }
    /*
    |--------------------------------------------------------------------------
    | Relate with Media Model
    |--------------------------------------------------------------------------
    */
    public function avatarImage(){
        return $this->hasOne(Media::class,'id','image_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Card url in view page
    |--------------------------------------------------------------------------
    */
    public function getCardUrlAttribute(){
        return $this->avatarImage->getUrl('card');
    }
    /*
    |--------------------------------------------------------------------------
    | Call Thumb url in view page
    |--------------------------------------------------------------------------
    */
    public function getAvatarUrlAttribute(){
        return $this->avatarImage->getUrl('avatar');
    }


}