<?php

namespace Modules\Acl\Http\Resources\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class socialAdviserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->social->name->value ?? "",
            'social_id' => $this->social->id,
            'value' => $this->value,
            'logo'=>  $this->social->logo ? getFile($this->social->logo->file??null,pathType()['ip'],getFileNameServer($this->social->logo)) : asset('public/images/test1.svg'),
        ];
    }
}
