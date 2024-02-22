<?php

namespace Modules\Setting\Http\Resources\Notification\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name(),
            'description' => $this->description(),
            'date' => $this->created_at->format('d/m/Y h:m:i'),
            'read_at' => $this->read_at ? 1 : 0,
        ];
    }
}
