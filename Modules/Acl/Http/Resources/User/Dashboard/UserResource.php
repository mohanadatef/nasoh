<?php

namespace Modules\Acl\Http\Resources\User\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleResource;
use Modules\Basic\Traits\validationRulesTrait;

class UserResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role' => new RoleResource($this->role),
            'email' => $this->email,
            'name' => $this->name,
            'lang' => $this->lang,
            'status' => $this->status,
        ];
    }
}
