<?php

namespace Modules\Acl\Http\Resources\Adviser\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Adviser\DocumentAdviserResource;
use Modules\Basic\Http\Resources\Media\mediaResource;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Http\Resources\Category\Adviser\CategoryProfileResource;

class AdviserProfileResource extends JsonResource
{
    use validationRulesTrait;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => getImag($this->avatar,'adviser',$this->id),
            'description' => $this->description ?? "",
            'full_name'=>$this->full_name,
            'info'=>$this->info ?? "",
            'experience_year'=>$this->experience_year ?? "",
            'category' => CategoryProfileResource::collection($this->category),
            'document' =>  DocumentAdviserResource::collection($this->adviser_document),
            'advice_count'=>$this->advice()->count(),
            'rate'=>$this->rate,
        ];
    }
}
