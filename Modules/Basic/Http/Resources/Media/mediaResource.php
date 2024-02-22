<?php

namespace Modules\Basic\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class mediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file' => getFile($this->file,pathType()['ip'],getFileNameServer($this)),
        ];
    }
}
