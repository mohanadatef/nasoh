<?php

namespace Modules\Advice\Http\Resources\Advice\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Client\Client\ClientAdviceResource;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Http\Resources\Label\Adviser\LabelResource;
use Modules\CoreData\Http\Resources\Status\Client\StatusResource;

class AdviceListResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (float)$this->price,
            'date' => $this->created_at->format('d/m/Y h:m:i'),
            'status' =>  new StatusResource($this->status),
            'label' =>  new LabelResource($this->label),
            'client' =>  new ClientAdviceResource($this->client),
        ];
    }
}
