<?php

namespace Modules\Advice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Acl\Entities\Adviser;
use Modules\Acl\Entities\Client;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Label;
use Modules\CoreData\Entities\Payment;
use Modules\CoreData\Entities\Status;
use Modules\Setting\Entities\Notification;

class Advice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'price', 'adviser_id', 'client_id', 'tax', 'tax_adviser', 'status_id','payment_id','rate_other',
        'rate_speed','rate_quality', 'rate_flexibility','rate_adviser','rate_app','comment_id','comment_note','label_id'
    ];
    protected $table = 'advices';
    public $timestamps = true;
    public static $rules = [
        'name' => 'required|min:17|max:35|string',
        'description' => 'required|min:5|max:500|string',
        'adviser_id' => 'required|exists:advisers,id',
        'price' => 'required|numeric',
    ];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public static function getValidationRulesReview()
    {
        return [
            'rate_speed'=>'required|in:0,1,2,3,4,5',
            'rate_quality'=>'required|in:0,1,2,3,4,5',
            'rate_flexibility'=>'required|in:0,1,2,3,4,5',
            'rate_adviser'=>'required|in:0,1',
            'rate_app'=>'required|in:0,1',
        ];
    }

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

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class)->orderBy('id','desc');
    }

    public function notification()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->chat()->delete();

        });
    }
}
