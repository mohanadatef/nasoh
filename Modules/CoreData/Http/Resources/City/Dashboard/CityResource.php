<?php

namespace Modules\CoreData\Http\Resources\City\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;
use Modules\CoreData\Http\Resources\Country\Dashboard\CountryListResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => new CountryListResource($this->country),
            'name' => translationResource::collection($this->translation->where('key','name')),
            'status' => $this->status,
        ];
    }
}
