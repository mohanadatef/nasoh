<?php

namespace Modules\Acl\Http\Resources\Adviser\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class AdviserAdviceResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'full_name'=>$this->full_name,
            'rate'=>$this->rate,
            'info'=>$this->info,
        ];
    }
}
