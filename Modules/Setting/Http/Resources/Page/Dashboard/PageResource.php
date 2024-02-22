<?php

namespace Modules\Setting\Http\Resources\Page\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type ?? "",
            'status' => $this->status,
            'name'=>   translationResource::collection($this->translation->where('key','name')),
            'description'=>   translationResource::collection($this->translation->where('key','description')),
        ];
    }
}
