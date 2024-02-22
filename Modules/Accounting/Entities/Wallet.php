<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'balance','key'
    ];
    protected $table = 'wallets';
    public $timestamps = true;
    public static $rules = [
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

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }


    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {

        });
    }
}
