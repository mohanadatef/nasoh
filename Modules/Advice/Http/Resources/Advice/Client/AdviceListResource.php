<?php

namespace Modules\Advice\Http\Resources\Advice\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Adviser\Adviser\AdviserAdviceResource;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Http\Resources\Label\Client\LabelResource;
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
            'adviser' =>  new AdviserAdviceResource($this->adviser),
            'label' =>  new LabelResource($this->label),
        ];
    }
}
