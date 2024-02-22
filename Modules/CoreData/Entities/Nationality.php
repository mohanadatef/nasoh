<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;
use Modules\Basic\Entities\Translation;

class Nationality extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'status','code'
    ];
    protected $table = 'nationalities';
    public $timestamps = true;

    public static $rules = [
        'logo.*.type' => 'mimes:jpg,jpeg,png,gif',
        'code' => 'required|string|unique:nationalities',
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

      public function name()
    {
        return $this->morphone(Translation::class, 'category')
            ->where('key', 'name')
            ->where('language_id', languageId());
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function logo()
    {
        return $this->media()->whereType(mediaType()['lm']);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->translation()->delete();
            $data->media()->delete();
        });


    }
}
