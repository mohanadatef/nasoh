<?php

namespace Modules\Acl\Http\Resources\User\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleListResource;
use Modules\Basic\Traits\validationRulesTrait;

class UserLoginResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'email' => $this->email,
            'full_name'=>$this->full_name,
            'token'=>$this->token,
            'role'=>new RoleListResource($this->role),
            'is_notification'=>$this->is_notification,
        ];
    }
}
