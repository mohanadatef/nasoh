<?php

namespace Modules\CoreData\Http\Resources\Nationality\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class NationalityListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'code' => $this->code ?? "",
            'status' => $this->status ?? "",
            'logo'=>  $this->logo ? getFile($this->logo->file??null,pathType()['ip'],getFileNameServer($this->logo)) : '',
        ];
    }
}
