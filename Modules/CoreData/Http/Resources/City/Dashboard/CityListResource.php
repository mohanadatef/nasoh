<?php

namespace Modules\CoreData\Http\Resources\City\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\Country\Dashboard\CountryListResource;

class CityListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => new CountryListResource($this->country),
            'name' => $this->name->value ?? "",
            'status' => $this->status,
        ];
    }
}
