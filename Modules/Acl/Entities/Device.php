<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device'
    ];
    protected $table = 'devices';
    public $searchRelationShip  = [];
    public $timestamps = true;

    public static function translationKey()
    {
        return [];
    }
    public function device()
    {
        return $this->morphTo();
    }

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
}
