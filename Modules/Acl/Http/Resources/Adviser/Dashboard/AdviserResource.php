<?php

namespace Modules\Acl\Http\Resources\Adviser\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Adviser\DocumentAdviserResource;
use Modules\Acl\Http\Resources\Adviser\socialAdviserResource;
use Modules\Basic\Http\Resources\Media\mediaResource;
use Modules\CoreData\Http\Resources\Category\Adviser\CategoryResource;
use Modules\CoreData\Http\Resources\City\Adviser\CityResource;
use Modules\CoreData\Http\Resources\Country\Adviser\CountryResource;
use Modules\CoreData\Http\Resources\Nationality\Adviser\NationalityResource;

class AdviserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'email' => $this->email,
            'description' => $this->description ?? "",
            'lang' => $this->lang ?? languageLocale(),
            'full_name'=>$this->full_name,
            'mobile'=>$this->mobile,
            'user_name'=>$this->user_name,
            'info'=>$this->info ?? "",
            'gender'=>$this->gender ?? "",
            'country_id'=>new CountryResource($this->country),
            'city_id'=>new CityResource($this->city),
            'experience_year'=>$this->experience_year ?? "",
            'bank_name'=>$this->bank_name ?? "",
            'bank_account'=>$this->bank_account ?? "",
            'birthday'=>$this->birthday ?? "",
            'status'=>$this->status,
            'nationality_id'=>new NationalityResource($this->nationality),
            'category' => CategoryResource::collection($this->category),
            'social' => socialAdviserResource::collection($this->adviser_social),
            'document' =>  DocumentAdviserResource::collection($this->adviser_document),
        ];
    }
}
