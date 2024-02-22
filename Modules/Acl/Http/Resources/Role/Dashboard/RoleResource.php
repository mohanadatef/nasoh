<?php

namespace Modules\Acl\Http\Resources\Role\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Permission\Dashboard\PermissionListResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'status' => $this->status,
            'permission'=>PermissionListResource::collection($this->permission),
        ];
    }
}
