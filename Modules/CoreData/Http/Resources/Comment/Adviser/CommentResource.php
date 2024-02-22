<?php

namespace Modules\CoreData\Http\Resources\Comment\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
        ];
    }
}
