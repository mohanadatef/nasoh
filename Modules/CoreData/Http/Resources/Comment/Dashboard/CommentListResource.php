<?php

namespace Modules\CoreData\Http\Resources\Comment\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'status' => $this->status ?? "",
            'type' => $this->type ?? "",
        ];
    }
}
