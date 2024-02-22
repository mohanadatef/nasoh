<?php

namespace Modules\Acl\Http\Resources\Permission\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name->value ?? "",
            'status' => $this->status,
        ];
    }
}
