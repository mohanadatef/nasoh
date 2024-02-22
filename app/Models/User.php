<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Acl\Entities\Device;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'status',
        'lang',
        'token',
        'name',
        'role_id'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    protected static $PasswordRules = ['password' => 'required|min:8'];
    public static $rules = [
        'name' => 'required|min:6|max:44|string',
        'email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]/|min:2|max:50|email|unique:users',
        'role_id' => 'required|exists:roles,id',
    ];
    public static function getValidationRules()
    {
        return array_merge(self::$rules, self::$PasswordRules);
    }
    public static function getValidationRulesUpdate()
    {
        return self::$rules;
    }
    public static function getValidationRulesLogin()
    {
        return self::$PasswordRules;
    }
    public function translationKey()
    {
        return [];
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
            $user->devices()->delete();
        });
    }
}
