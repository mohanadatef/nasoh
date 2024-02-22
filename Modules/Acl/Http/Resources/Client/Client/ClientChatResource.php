<?php

namespace Modules\Acl\Http\Resources\Client\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'client',$this->id),
            'full_name'=>$this->full_name,
        ];
    }
}
