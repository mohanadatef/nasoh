<?php

namespace App\Http\Middleware;

use Closure;
use Modules\Basic\Traits\ApiResponseTrait;

class PermissionMiddelware
{
    use ApiResponseTrait;
    public function handle($request, Closure $next, $permission)
    {
        return permissionShow($permission) ? $next($request) : (!$request->expectsJson() ? abort(403): $this->unauthorizedResponse('403'));
    }
}
