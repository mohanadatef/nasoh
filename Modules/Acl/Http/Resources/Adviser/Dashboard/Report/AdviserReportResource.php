<?php

namespace Modules\Acl\Http\Resources\Adviser\Dashboard\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class AdviserReportResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'total' => $this['total'],
            'advice' => $this['advice'],
            'active' => $this['active'],
            'inactive' => $this['inactive'],
        ];
    }
}
