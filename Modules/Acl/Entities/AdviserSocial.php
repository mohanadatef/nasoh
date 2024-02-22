<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Social;

class AdviserSocial extends Model
{
    protected $fillable = [
        'adviser_id','social_id','value'
    ];
    protected $table = 'adviser_socials';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip  = [];
    public function social()
    {
        return $this->belongsTo(Social::Class);
    }
}
