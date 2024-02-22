<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Basic\Entities\Translation;

class Role extends Model
{
    protected $fillable = [
        'status'
    ];

    protected $table = 'roles';

    public $timestamps = true;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['name', 'permission'];

    public $searchRelationShip = [];



    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];

    public static function translationKey()
    {
        return ['name'];
    }


    public function translation()
    {
        return $this->morphMany(Translation::class, 'category');
    }

    public static $rules = [
        'permission' => 'array|exists:permissions,id',
    ];

    public static function getValidationRules()
    {
        return self::$rules;
    }

      public function name()
    {
        return $this->morphone(Translation::class, 'category')
            ->where('key', 'name')
            ->where('language_id', languageId());
    }

    public function nameValue()
    {
        $names=$this->morphone(Translation::class, 'category')
            ->where('key' ,'name')->get();
        return $names->pluck('value','language.code')->toArray();
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::Class, 'role_permissions');
    }

    public function role_permission()
    {
        return $this->hasManyThrough(Permission::Class, RolePermission::Class, 'role_id', 'id', 'id', 'permission_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($role) {
            $role->translation()->delete();
            $role->role_permission()->delete();
        });
    }
}
