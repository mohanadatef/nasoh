<?php

namespace Modules\Accounting\Http\Resources\Wallet\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounting\Http\Resources\Transaction\Adviser\TransactionResource;

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
