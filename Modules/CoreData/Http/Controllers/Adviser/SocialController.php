<?php

namespace Modules\CoreData\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Social\Adviser\SocialResource;
use Modules\CoreData\Service\SocialService;

class SocialController extends BasicController
{
    public $service;

    public function __construct(SocialService $Service)
    {
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        return $this->apiResponse(SocialResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
