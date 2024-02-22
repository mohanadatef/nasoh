<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type', 'pusher_id','receiver_id','read_at','notifiable_type','notifiable_id','action'
    ];
    protected $table = 'notifications';
    public $timestamps = true;
    public $searchRelationShip = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    public static function translationKey(){
        return [];
    }
    protected $with = [];
    protected $appends = [];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];

    public function pusher()
    {
        return $this->belongsTo(User::class, 'pusher_id');
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
    public function name()
    {
        return "";
    }
    public function description()
    {
        return "";
    }
}
