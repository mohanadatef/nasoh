<?php

namespace Modules\Setting\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Service\PageService;
use Modules\Setting\Http\Resources\Page\Client\PageResource;

class PageController extends BasicController
{
    public $service;

    public function __construct(PageService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }

    public function policyPage(Request $request)
    {
        $request->merge(['type'=>'client','key'=>'policy']);
        $data = $this->service->findBy($request, get:'first');
        if($data)
        {
        return $this->apiResponse(new PageResource($this->service->findBy($request, get:'first')), 'Done');
        }
        return $this->apiResponse([], 'Done');
    }

}
