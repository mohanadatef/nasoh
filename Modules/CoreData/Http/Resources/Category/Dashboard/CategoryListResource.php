<?php

namespace Modules\CoreData\Http\Resources\Category\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'parent' => new  CategoryListResource($this->parents),
            'status'=>$this->status,
        ];
    }
}
