<?php

namespace Modules\Acl\Entities;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'permission_id','role_id'
    ];
    protected $table = 'role_permissions';
    public $timestamps = true;


    public static function boot() {
        parent::boot();
        static::deleting(function($role_permission) {
            $role_permission->delete();
        });
    }
}
