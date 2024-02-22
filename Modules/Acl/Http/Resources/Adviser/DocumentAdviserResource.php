<?php

namespace Modules\Acl\Http\Resources\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentAdviserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}
