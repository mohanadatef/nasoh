<?php

namespace Modules\CoreData\Http\Resources\Label\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class LabelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'status' => $this->status,
        ];
    }
}
