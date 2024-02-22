<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Advice\Entities\Advice;
use Modules\Basic\Entities\Media;
use Laravel\Passport\HasApiTokens;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\City;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Entities\Nationality;
use Modules\CoreData\Entities\Social;

class Adviser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'mobile', 'user_name', 'lang', 'info', 'gender', 'country_id', 'city_id', 'description', 'experience_year', 'bank_name',
        'bank_account', 'birthday', 'nationality_id', 'status', 'token','rate','speed','quality','flexibility','wallet_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    public $searchConfig = ['mobile'=>'like','full_name'=>'like'];
    public $searchRelationShip = [
        'category' => 'adviser_category->category_id',
    ];
    public static $rules = [
        'user_name' => 'required|min:4|max:17|regex:/^[-0-9a-zA-Z.+_]+$/u|string|unique:advisers',
        'full_name' => 'required|min:2|max:33|string',
        'email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]/|min:2|max:50|email|unique:advisers',
        'mobile' => 'required|numeric|digits_between:8,17|unique:advisers',
        'category' => 'required|array|exists:categories,id',
        'info' => 'string|min:4|max:770',
        'experience_year' => 'numeric|nullable|min:1|max:99',
        'social' => 'array',
        'social.*.value' => 'string',
    ];
    public function translationKey()
    {
        return [];
    }
    public static $rulesUpdate = [
        'avatar.*.type' => 'mimes:jpg,jpeg,png,gif',
        'description' => 'string|min:70|max:770',
    ];

    protected static $PasswordRules = ['password' => 'required|min:6|max:10'];

    public static function getValidationRules()
    {
        return array_merge(self::$rules, self::$PasswordRules);
    }

    public static function getValidationRulesLogin()
    {
        return self::$PasswordRules;
    }

    public static function getValidationRulesUpdate()
    {
        return self::$rules;
    }

    public static function getValidationRulesPassword()
    {
        return self::$PasswordRules;
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
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

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'adviser_categories');
    }

    public function adviser_category()
    {
        return $this->hasMany(AdviserCategory::class);
    }

    public function adviser_document()
    {
        return $this->hasMany(AdviserDocument::class);
    }

    public function social()
    {
        return $this->belongsToMany(Social::class, 'adviser_socials');
    }

    public function adviser_social()
    {
        return $this->hasMany(AdviserSocial::class);
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
            $user->adviser_category()->delete();
            $user->adviser_social()->delete();
            $user->adviser_document()->delete();
        });
    }
}
