<?php

namespace Modules\Setting\Http\Resources\Setting\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key' => $this->key ?? "",
            'value' => $this->value ?? "",
        ];
    }
}
