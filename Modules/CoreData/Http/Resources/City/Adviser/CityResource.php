<?php

namespace Modules\CoreData\Http\Resources\City\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\Country\Adviser\CountryResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => new CountryResource($this->country),
            'name' => $this->name->value ?? "",
        ];
    }
}
