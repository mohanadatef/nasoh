<?php

namespace Modules\CoreData\Http\Resources\Country\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryListResource extends JsonResource
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
