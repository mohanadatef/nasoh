<?php

namespace Modules\Acl\Entities;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Accounting\Entities\Wallet;
use Modules\Advice\Entities\Advice;
use Modules\Basic\Entities\Media;
use Laravel\Passport\HasApiTokens;
use Modules\CoreData\Entities\City;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Entities\Nationality;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'full_name', 'email', 'mobile', 'lang', 'status', 'nationality_id','token','country_id', 'city_id', 'gender','wallet_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    public $searchConfig = ['mobile'=>'like'];
    public static $rules = [
        'full_name' => 'required|min:2|max:33|string',
        'email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]/|min:2|max:50|email|unique:clients',
        'mobile' => 'required|numeric|digits_between:8,17|unique:clients',
        'country_id' => 'nullable|exists:countries,id',
        'city_id' => 'nullable|exists:cities,id',
    ];
    public function translationKey()
    {
        return [];
    }
    public static $rulesUpdate = [
        'avatar.*.type' => 'mimes:jpg,jpeg,png,gif',
    ];


    public static function getValidationRules()
    {
        return self::$rules;
    }

    public static function getValidationRulesUpdate()
    {
        return self::$rules;
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'category');
    }

    public function avatar()
    {
        return $this->media()->whereType(mediaType()['am']);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function advice()
    {
        return $this->hasMany(Advice::class);
    }
    public function device()
    {
        return $this->morphOne(Device::class, 'category');
    }

    public function devices()
    {
        return $this->morphMany(Device::class, 'category');
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->medias()->delete();
            $user->devices()->delete();
            $user->wallet()->delete();
            $user->advice()->delete();
        });
    }
}
