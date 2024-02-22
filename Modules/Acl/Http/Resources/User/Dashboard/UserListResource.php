<?php

namespace Modules\Acl\Http\Resources\User\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleListResource;
use Modules\Basic\Traits\validationRulesTrait;

class UserListResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role' => new RoleListResource($this->role),
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status,
            'lang' => $this->lang,
        ];
    }
}
