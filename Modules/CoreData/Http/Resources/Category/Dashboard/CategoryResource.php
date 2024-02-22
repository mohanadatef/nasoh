<?php

namespace Modules\CoreData\Http\Resources\Category\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'parent' => new  CategoryListResource($this->parents),
            'status'=>$this->status,
        ];
    }
}
