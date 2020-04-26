<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Notifications\Notifiable;





use App\Order;
use App\User;
use App\State;
use App\StoreRoom;
use App\City;
use App\SpecialTariff;
use App\MoneyCirculation;
use App\UserInventory;
use App\BankAccount;
use App\PaymentCirculation;
use App\AgentCost;

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
        'factorPrice',
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
        return $this->hasMany(Order::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Releation with Order Model
    |--------------------------------------------------------------------------
    */
    public function orderAgent(){
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function orderFollowUpManager(){
        return $this->hasMany(User::class,'followUpManager_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function orderCallCenter(){
        return $this->hasMany(User::class,'callCenter_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function callcenter(){
        return $this->belongsTo(User::class, 'callCenter');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function statesUnderControl(){
        return $this->hasMany(State::class,'followUpManager','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function receives(){
        return $this->hasMany(StoreRoom::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function sends(){
        return $this->hasMany(StoreRoom::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with State Model
    |--------------------------------------------------------------------------
    */
    public function state(){
      return $this->belongsTo(State::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with City Model
    |--------------------------------------------------------------------------
    */
    public function city(){
        return $this->belongsTo(City::class);
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
      return $this->hasMany(SpecialTariff::class);
    }
   
    /*
    |--------------------------------------------------------------------------
    | Releate with MoneyCirculation - seller
    |--------------------------------------------------------------------------
    */
    public function MoneyCirculations(){
        return $this->hasMany(MoneyCirculation::class,'user_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releate with UserInventory - agent
    |--------------------------------------------------------------------------
    */
    public function agentInventories(){
        return $this->hasMany(UserInventory::class,'agent_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releate with UserInventory - seller
    |--------------------------------------------------------------------------
    */
    public function sellerInventories(){
        return $this->hasMany(UserInventory::class,'seller_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with BankAccount Model
    |--------------------------------------------------------------------------
    */
    public function bank_accounts(){
        return $this->hasMany(BankAccount::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with Payment Circulation Model
    |--------------------------------------------------------------------------
    */
    public function payment_circulations(){
        return $this->hasMany(PaymentCirculation::class,'bank_account_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function agent_costs(){
        return $this->hasMany(AgentCost::class);
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
