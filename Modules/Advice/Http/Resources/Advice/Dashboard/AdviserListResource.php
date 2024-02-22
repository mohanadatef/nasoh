<?php

namespace Modules\Advice\Http\Resources\Advice\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Http\Resources\Status\Dashboard\StatusResource;

class AdviserListResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        $tax= round($this->price *  ($this->tax / 100),2);
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'client'=>$this->client->full_name,
            'adviser'=>$this->adviser->full_name,
            'status'=>new StatusResource($this->status),
            'chat_count'=>$this->chat->count(),
            'total_price'=>$this->price + $tax,

        ];
    }
}
