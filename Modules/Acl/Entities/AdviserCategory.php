<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Category;

class AdviserCategory extends Model
{
    protected $fillable = [
        'adviser_id','category_id'
    ];
    protected $table = 'adviser_categories';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip  = [];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
