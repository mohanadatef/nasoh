<?php

namespace Modules\Setting\Http\Resources\HomeSlider\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeSliderListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url ?? "",
            'image'=>  $this->image ? getFile($this->image->file??null,pathType()['ip'],getFileNameServer($this->image)) : '',
        ];
    }
}
