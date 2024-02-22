<?php

namespace Modules\CoreData\Http\Resources\Status\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusListResource extends JsonResource
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
