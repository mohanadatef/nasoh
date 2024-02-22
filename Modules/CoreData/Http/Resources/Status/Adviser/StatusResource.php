<?php

namespace Modules\CoreData\Http\Resources\Status\Adviser;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    public function toArray($request)
    {
        if($this->id != 1)
        {
        $total = $this->advice()->where('adviser_id',user('adviser')->id)->count();
        }else{
            $total = $this->advice()->where('adviser_id',user('adviser')->id)->where('label_id','!=',1)->count();
        }
        return [
            'id' => $this->id,
            'name' =>  $this->name->value ?? "",
            'total'=>$total
        ];
    }
}
