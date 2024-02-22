<?php

namespace Modules\Acl\Http\Resources\Adviser\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class AdviserChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'full_name'=>$this->full_name,
        ];
    }
}
