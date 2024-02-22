<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Translation;

class Page extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'status','type','key'
    ];
    protected $table = 'pages';
    public $timestamps = true;

    public static $rules = [
        'type' => 'required|string|in:client,adviser',
        'key' => 'required|string',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['name','description'];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public static function translationKey()
    {
        return ['name','description'];
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
    public function description()
    {
        return $this->morphone(Translation::class, 'category')
            ->where('key', 'description')
            ->where('language_id', languageId());
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->translation()->delete();
        });


    }
}
