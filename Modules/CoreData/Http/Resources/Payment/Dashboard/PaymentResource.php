<?php

namespace Modules\CoreData\Http\Resources\Payment\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => translationResource::collection($this->translation->where('key','name')),
            'status' => $this->status ?? "",
            'logo'=>  $this->logo ? getFile($this->logo->file??null,pathType()['ip'],getFileNameServer($this->logo)) : '',
        ];
    }
}
