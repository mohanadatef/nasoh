<?php

namespace Modules\CoreData\Http\Resources\Comment\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'status' => $this->status ?? "",
            'type' => $this->type ?? "",
        ];
    }
}
