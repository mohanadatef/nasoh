<?php

namespace Modules\Setting\Http\Resources\Setting\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Http\Resources\Translation\translationResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key ?? "",
            'value' => $this->value ?? "",
        ];
    }
}
