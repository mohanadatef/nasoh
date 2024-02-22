<?php

namespace Modules\Setting\Http\Resources\Page\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PageListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type ?? "",
            'name' => $this->name->value ?? "",
            'status' => $this->status,
        ];
    }
}
