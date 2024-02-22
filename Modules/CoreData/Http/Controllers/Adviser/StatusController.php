<?php

namespace Modules\CoreData\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Advice\Entities\Advice;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Status\Adviser\StatusResource;
use Modules\CoreData\Service\StatusService;

class StatusController extends BasicController
{
    public $service;

    public function __construct(StatusService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        $data = StatusResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage()));
        $data=$data->prepend(['id'=>0,'name'=>'الكل','total'=>Advice::where('adviser_id',user('adviser')->id)->where('label_id','!=',1)->count()]);
        return $this->apiResponse($data, 'Done');
    }
}
