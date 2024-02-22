<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Setting\Service\SettingService;

/**
 * @Target this file to make function to help for all system
 * @note can call it in all system
 */
/**
 * user login
 */
function user($type = null)
{
    if (Auth::guard($type)->check()){
        return Auth::guard($type)->user();
    }
}

/**
 * to execution time for web
 */
function executionTime()
{
    ini_set('max_execution_time', 120000);
    ini_set('post_max_size', 120000);
    ini_set('upload_max_filesize', 100000);
}
function permissionShow($name)
{
    return \Illuminate\Support\Facades\DB::table('permissions')
        ->join('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->where('role_permissions.role_id', user('dashboard')->role_id ?? 0)->where('permissions.name', $name)->count();
}

function getSetting($key)
{
    return app()->make(SettingService::class)->findBy(new Request(['key' => strtolower($key)]), get:'first') ?? "";
}