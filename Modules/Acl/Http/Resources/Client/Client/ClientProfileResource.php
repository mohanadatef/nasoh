<?php

namespace Modules\Acl\Http\Resources\Client\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\City\Client\CityResource;
use Modules\CoreData\Http\Resources\Country\Client\CountryResource;
use Modules\CoreData\Http\Resources\Nationality\Client\NationalityResource;

class ClientProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'client',$this->id),
            'email' => $this->email,
            'lang' => $this->lang ?? languageLocale(),
            'full_name'=>$this->full_name,
            'mobile'=>$this->mobile,
            'gender'=>$this->gender ?? "",
            'country_id'=>new CountryResource($this->country),
            'city_id'=>new CityResource($this->city),
            'nationality_id'=>new NationalityResource($this->nationality),
        ];
    }
}
