<?php

namespace Modules\Acl\Http\Resources\Adviser\Dashboard\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class AdviserProfileReportResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'total' => $this['total'],
            'wallet'=>$this['wallet'],
        ];
    }
}
