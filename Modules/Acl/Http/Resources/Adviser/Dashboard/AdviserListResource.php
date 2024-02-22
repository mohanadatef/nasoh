<?php

namespace Modules\Acl\Http\Resources\Adviser\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class AdviserListResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name'=>$this->full_name,
            'mobile'=>$this->mobile,
            'status'=>$this->status,
            'wallet'=>$this->wallet->balance ?? "",
            'advice'=>$this->advice()->count() ?? "",
            'balance_done'=>0,
            'balance_come'=>0,
        ];
    }
}
