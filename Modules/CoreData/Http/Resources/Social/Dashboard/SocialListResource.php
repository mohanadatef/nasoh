<?php

namespace Modules\CoreData\Http\Resources\Social\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name->value ?? "",
            'status' => $this->status,
            'logo'=>  $this->logo ? getFile($this->logo->file??null,pathType()['ip'],getFileNameServer($this->logo)) : '',
        ];
    }
}
