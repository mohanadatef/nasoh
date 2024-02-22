<?php

namespace Modules\Advice\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Adviser\Adviser\AdviserChatResource;
use Modules\Acl\Http\Resources\Client\Client\ClientChatResource;
use Modules\Basic\Http\Resources\Media\mediaResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'adviser' => new AdviserChatResource($this->adviser),
            'client' => new ClientChatResource($this->client),
            'message' => $this->message,
            'media_type' => $this->media_type,
            'document' => mediaResource::collection($this->document),
            'date' => $this->created_at->format('d/m/Y h:m:i'),
        ];
    }
}
