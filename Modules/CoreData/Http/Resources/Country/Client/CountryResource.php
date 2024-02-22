<?php

namespace Modules\CoreData\Http\Resources\Country\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
        ];
    }
}
