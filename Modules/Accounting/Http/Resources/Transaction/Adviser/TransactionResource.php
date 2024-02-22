<?php

namespace Modules\Accounting\Http\Resources\Transaction\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $description = trans('wallet.'.str_replace("key","description", $this->key));
        $description =str_replace(":id",'#'.$this->id,$description);
        $description =str_replace(":advice",'#'.$this->advice_id,$description);
        return [
            'id' => $this->id,
            'balance' => (float)$this->balance,
            'key' => trans('wallet.'.$this->key),
            'description' =>$description,
        ];
    }
}
