<?php

namespace Modules\Accounting\Http\Resources\Wallet\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => (float)$this->balance,

        ];
    }
}
