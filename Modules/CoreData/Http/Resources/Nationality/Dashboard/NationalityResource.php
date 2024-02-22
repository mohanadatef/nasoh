<?php

namespace Modules\CoreData\Http\Resources\Nationality\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class NationalityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'code' => $this->code ?? "",
            'status' => $this->status ?? "",
            'logo'=>  $this->logo ? getFile($this->logo->file??null,pathType()['ip'],getFileNameServer($this->logo)) : '',
        ];
    }
}
