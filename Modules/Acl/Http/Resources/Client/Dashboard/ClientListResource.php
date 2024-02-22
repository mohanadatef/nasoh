<?php

namespace Modules\Acl\Http\Resources\Client\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name'=>$this->full_name,
            'status'=>$this->status,
            'wallet'=>$this->wallet->balance ?? "",
        ];
    }
}
