<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'city_id',
        'address',
        'uploadCS',
        'level',
        'backToWareHouse',
        'backToFollowManager',
        'sendAuto',
        'callCenter',
        'agent_id',
        'porsantSeller',
        'percent',
        'calType',
        'locallyPrice',
        'internalPrice',
        'villagePrice',
        'uploadCS_status',
        'allowNumber',
        'backToSeller',
        'allowNumberDup',
        'allowNewOrder',
        'messageStatus',
        'determinPercent',
        'porsantType',
        'forceOrder',
        'callCenterType',
        'allowNumberEdit',
        'calTypeCallCenter'
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
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orderSeller(){
        return $this->hasMany('App\Order');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orderAgent(){
        return $this->hasMany('App\Order');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function orderFollowUpManager(){
        return $this->hasMany('App\User','followUpManager_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function orderCallCenter(){
        return $this->hasMany('App\User','callCenter_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function statesUnderControl(){
        return $this->hasMany('App\State','followUpManager','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function receives(){
        return $this->hasMany('App\StoreRoom');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function sends(){
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
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function city(){
        return $this->belongsTo('App\City');
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
    | Releate with MoneyCirculation - seller
    |--------------------------------------------------------------------------
    */
    public function MoneyCirculations(){
        return $this->hasMany('App\MoneyCirculation','user_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with UserInventory - agent
    |--------------------------------------------------------------------------
    */
    public function agentInventories(){
        return $this->hasMany('App\UserInventory','agent_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releate with UserInventory - seller
    |--------------------------------------------------------------------------
    */
    public function sellerInventories(){
        return $this->hasMany('App\UserInventory','seller_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with BankAccount Model
    |--------------------------------------------------------------------------
    */
    public function bank_accounts(){
        return $this->hasMany('App\BankAccount');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Payment Circulation Model
    |--------------------------------------------------------------------------
    */
    public function payment_circulations(){
        return $this->hasMany('App\PaymentCirculation','bank_account_id','id');
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
