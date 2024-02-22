<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Basic\Entities\Translation;

class Permission extends Model
{


    protected $fillable = [
        'name'
    ];

    protected $table = 'permissions';

    public $timestamps = true;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    public $searchRelationShip = [];

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];

    public static function translationKey()
    {
        return ['display_name'];
    }

    public static $rules = [];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function translation()
    {
        return $this->morphMany(Translation::class, 'category');
    }

    public function display_name()
    {
        return $this->morphone(Translation::class, 'category')
            ->where('key', 'display_name')
            ->where('language_id', languageId());
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function role_permission()
    {
        return $this->hasMany(RolePermission::Class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($permission) {
            $permission->translation()->delete();
            $permission->role_permission()->delete();
        });
    }
}
