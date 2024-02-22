<?php

namespace Modules\Advice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Acl\Entities\Adviser;
use Modules\Acl\Entities\Client;
use Modules\Basic\Entities\Media;

class Chat extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message', 'media_type', 'adviser_id', 'client_id','advice_id'
    ];
    protected $table = 'chats';
    public $timestamps = true;
    public static $rules = [];

    public function translationKey()
    {
        return [];
    }

    public function adviser()
    {
        return $this->belongsTo(Adviser::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function advice()
    {
        return $this->belongsTo(Advice::class);
    }
    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }
    public function medias()
    {
        return $this->morphMany(Media::class, 'category');
    }

    public function document()
    {
        return $this->medias()->whereType(mediaType()['dm']);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->medias()->delete();
        });
    }
}
