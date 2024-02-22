<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;

class HomeSlider extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'status','url'
    ];
    protected $table = 'home_sliders';
    public $timestamps = true;

    public static $rules = [
        'image.*.type' => 'mimes:jpg,png',
        'url' => 'nullable|string',
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
    protected $with = [];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public static function translationKey()
    {
        return [];
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function image()
    {
        return $this->media()->whereType(mediaType()['im']);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->media()->delete();
        });


    }
}
