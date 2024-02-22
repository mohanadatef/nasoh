<?php

namespace Modules\CoreData\Http\Resources\Label\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LabelListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'status' => $this->status,
        ];
    }
}
