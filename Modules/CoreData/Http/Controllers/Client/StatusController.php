<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Status\Client\StatusResource;
use Modules\CoreData\Service\StatusService;

class StatusController extends BasicController
{
    public $service;

    public function __construct(StatusService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        $data=StatusResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage()));
        $data=$data->prepend(['id'=>0,'name'=>'الكل']);
        return $this->apiResponse($data, 'Done');
    }
}
