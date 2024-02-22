<?php

namespace Modules\Accounting\Http\Resources\Wallet\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounting\Http\Resources\Transaction\Client\TransactionResource;

class WalletListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => (float)$this->balance,
            'transaction'=>TransactionResource::collection($this->transaction)
        ];
    }
}
