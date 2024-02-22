<?php

namespace Modules\Basic\Http\Resources\Translation;

use Illuminate\Http\Resources\Json\JsonResource;

class translationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lang' => $this->language->code,
            'value' => $this->value,
        ];
    }
}
