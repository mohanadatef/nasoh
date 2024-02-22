<?php

namespace Modules\Advice\Http\Resources\Advice\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Adviser\Client\AdviserListResource;
use Modules\Advice\Http\Resources\Chat\ChatResource;
use Modules\CoreData\Http\Resources\Label\Client\LabelResource;
use Modules\CoreData\Http\Resources\Status\Client\StatusResource;

class AdviceResource extends JsonResource
{
    public function toArray($request)
    {
        $tax= round($this->price *  ($this->tax / 100),2);
        return [
            'id' => $this->id,
            'adviser' => new AdviserListResource($this->adviser),
            'price' =>  (float)$this->price,
            'tax' =>  $tax,
            'date' => $this->created_at->format('d/m/Y h:m:i'),
            'total'=> $this->price + $tax,
            'status' =>  new StatusResource($this->status),
            'chat' =>  ChatResource::collection($this->chat),
            'label' =>  new LabelResource($this->label),
        ];
    }
}
