<?php

namespace Modules\CoreData\Http\Resources\Label\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class LabelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name->value ?? "",
        ];
    }
}
