<?php

namespace Modules\Acl\Http\Resources\Adviser\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class AdviserLoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'email' => $this->email,
            'lang' => $this->lang ?? languageLocale(),
            'full_name'=>$this->full_name,
            'mobile'=>$this->mobile,
            'user_name'=>$this->user_name,
            'token'=>$this->token,
            'is_notification'=>(int)$this->is_notification,
            'is_advice'=>(int)$this->is_advice,
            'rate'=>$this->rate,
            'wallet_balance'=>0,
            'bank_complete'=>$this->bank_account ? 1 : 0,
            'status_count'=>$this->advice()->whereNot('label_id',1)->where('adviser_id',$this->id)->count(),
        ];
    }
}
