<?php

namespace Modules\Acl\Http\Resources\Permission\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'display_name' => translationResource::collection($this->translation->where('key','display_name')),
        ];
    }
}
