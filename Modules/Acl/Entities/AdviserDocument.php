<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class AdviserDocument extends Model
{
    protected $fillable = [
        'adviser_id','value'
    ];
    protected $table = 'adviser_documents';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip  = [];
}
