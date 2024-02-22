<?php

namespace Modules\Acl\Http\Resources\Adviser\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Http\Resources\Category\Adviser\CategoryProfileResource;
use Modules\CoreData\Http\Resources\Category\Client\CategoryResource;

class AdviserListResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'full_name'=>$this->full_name,
            'info'=>$this->info ?? "",
            'description'=>$this->description ?? "",
            'category' => CategoryProfileResource::collection($this->category),
            'rate'=>$this->rate,
        ];
    }
}
