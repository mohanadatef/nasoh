<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Nationality\Client\NationalityResource;
use Modules\CoreData\Service\NationalityService;

class NationalityController extends BasicController
{
    public $service;

    public function __construct(NationalityService $Service)
    {
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        return $this->apiResponse(NationalityResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
