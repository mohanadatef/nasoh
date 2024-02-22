<?php

namespace Modules\Basic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Language;

class Translation extends Model
{


    protected $fillable = [
        'key', 'value', 'language_id'
    ];
    protected $table = 'translations';
    public $searchRelationShip  = [];
    public $timestamps = true;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];
    public function translation()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
}
