<?php

namespace Modules\CoreData\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Translation;

class Language extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'code','name','status'
    ];
    protected $table = 'languages';
    public $timestamps = true;
    public $searchRelationShip = [];

    public static function translationKey()
    {
        return [];
    }

    public static $rules = [
        'name' => 'required|string|unique:languages',
        'code' => 'required|string|unique:languages',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function scopeStatus($query,$status)
    {
        return $query->whereStatus($status);
    }

    public function scopeOrder($query,$order)
    {
        return $query->orderby('order',$order);
    }

    public function translation()
    {
        return $this->hasMany(Translation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
