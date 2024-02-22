<?php

namespace Modules\Setting\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Service\PageService;
use Modules\Setting\Http\Resources\Page\Adviser\PageResource;

class PageController extends BasicController
{
    public $service;

    public function __construct(PageService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }

    public function policyPage(Request $request)
    {
        $request->merge(['type'=>'adviser','key'=>'policy']);
        return $this->apiResponse(new PageResource($this->service->findBy($request, get:'first')), 'Done');
    }

}
