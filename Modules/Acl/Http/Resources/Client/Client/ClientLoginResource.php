<?php

namespace Modules\Acl\Http\Resources\Client\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class ClientLoginResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        $mobile=$this->mobile;
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'client',$this->id),
            'email' => $this->email,
            'lang' => $this->lang ?? languageLocale(),
            'full_name'=>$this->full_name,
            'mobile'=>$mobile,
            'token'=>$this->token,
            'is_notification'=>(int)$this->is_notification,
            'wallet_balance'=>$this->wallet->balance ?? 0,
        ];
    }
}
