<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'value','key'
    ];
    protected $table = 'settings';
    public $timestamps = true;

    public static $rules = [
        'value.*' => 'required|string',
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

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });


    }
}
