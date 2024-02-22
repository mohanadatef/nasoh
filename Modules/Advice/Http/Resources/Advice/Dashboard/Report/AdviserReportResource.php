<?php

namespace Modules\Advice\Http\Resources\Advice\Dashboard\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;

class AdviserReportResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'total' => $this['total'],
            'complete' => $this['complete'],
            'reject' => $this['reject'],
            'objector' => $this['objector'],
        ];
    }
}
