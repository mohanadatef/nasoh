<?php

namespace Modules\CoreData\Http\Resources\Category\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'children' => CategoryResource::collection($this->children),
            'parent_id'=>$this->parent_id,
            'selected'=>false,
        ];
    }
}
