<?php

namespace Modules\CoreData\Http\Resources\Category\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryParentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
        ];
    }
}
