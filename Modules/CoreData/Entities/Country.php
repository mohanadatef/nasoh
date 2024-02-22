<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Translation;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status'
    ];
    protected $table = 'countries';
    public $timestamps = true;
    public static $rules = [
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name' => 'like'];
    public $searchRelationShip = [];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['name'];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public static function translationKey()
    {
        return ['name'];
    }

    public function translation()
    {
        return $this->morphMany(Translation::class, 'category');
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public function name()
    {
        return $this->morphone(Translation::class, 'category')
            ->where('key', 'name')
            ->where('language_id', languageId());
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->translation()->delete();
            $data->city()->delete();
        });
    }
}
